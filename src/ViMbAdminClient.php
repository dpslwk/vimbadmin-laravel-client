<?php

namespace LWK\ViMbAdmin;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use LWK\ViMbAdmin\Model\Alias;
use LWK\ViMbAdmin\Model\Mailbox;
use LWK\ViMbAdmin\Contracts\TokenStore;
use Sainsburys\Guzzle\Oauth2\AccessToken;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use LWK\ViMbAdmin\Middelware\ViMbAdminOAuthMiddleware;
use Sainsburys\Guzzle\Oauth2\GrantType\ClientCredentials;
use LWK\ViMbAdmin\Serializer\Normalizer\ViMbAdminNormalizer;

class ViMbAdminClient
{
    /**
     * @var TokenStore
     */
    protected $tokenStore;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var ViMbAdminNormalizer
     */
    protected $normalizer;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * ViMbAdminClient constructor.
     *
     * @param TokenStore                    $tokenStore
     * @param \Illuminate\Config\Repository $config
     * @param ViMbAdminNormalizer           $normalizer
     */
    public function __construct(
        TokenStore $tokenStore,
        \Illuminate\Config\Repository $config,
        ViMbAdminNormalizer $normalizer)
    {
        $this->tokenStore = $tokenStore;
        // TODO: strip traling / from url
        $this->apiUrl = $config->get('vimbadmin.api_url');
        $this->clientId = $config->get('vimbadmin.client_id');
        $this->clientSecret = $config->get('vimbadmin.client_secret');

        $this->normalizer = $normalizer;
        $this->serializer = new Serializer(array(
            $this->normalizer,
        ), array(
            'json' => new JsonEncoder(),
        ));

        $this->setupClient($this->apiUrl, $this->clientId, $this->clientSecret);
    }

    /**
     * GuzzleHttp Client setup helper, broken out after constructor is need to use none config crdientials.
     * @param  string $apiUrl
     * @param  string $clientId
     * @param  string $clientSecret
     * @param  string $tokenUri
     * @return self
     */
    public function setupClient(
        string $apiUrl,
        string $clientId,
        string $clientSecret,
        string $tokenUri = '/oauth/token')
    {
        $handlerStack = HandlerStack::create();
        $client = new Client(
            [
                'handler'=> $handlerStack,
                'base_uri' => $apiUrl,
                'auth' => 'oauth2',
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'exceptions' => false,
            ]
        );

        $config = [
            ClientCredentials::CONFIG_CLIENT_ID => $clientId,
            ClientCredentials::CONFIG_CLIENT_SECRET => $clientSecret,
            ClientCredentials::CONFIG_TOKEN_URL => $tokenUri,
        ];

        $grant = new ClientCredentials($client, $config);
        $middleware = new ViMbAdminOAuthMiddleware($client, $grant, null, $this->tokenStore);

        // see if we have a token already and load it.
        $key = $this->tokenStore->serializeKey($grant);
        $token = $this->tokenStore->findByKey($key);
        if ($token) {
            $accessToken = new AccessToken(
                $token->getToken(),
                $token->getType(),
                ['expires' => $token->getExpires()->getTimestamp()]
            );
            $middleware->setAccessToken($accessToken);
        }

        $handlerStack->push($middleware->onBefore());
        $handlerStack->push($middleware->onFailure(5));

        $this->client = $client;

        return $this;
    }

    /**
     * internal get helper.
     * @param  string $uri
     * @return mixed
     */
    private function get(string $uri)
    {
        $url = $this->apiUrl.'/'.$uri;
        $response = $this->client->get($url)->getBody();
        return $this->serializer->deserialize($response, null, 'json');
    }

    /**
     * internal post helper.
     * @param  string $uri
     * @param  string $json
     * @return mixed
     */
    private function post(string $uri, $json)
    {
        $url = $this->apiUrl.'/'.$uri;
        $response = $this->client->post($url, ['body' => $json])->getBody();
        return $this->serializer->deserialize($response, null, 'json');
    }

    /**
     * internal patch helper.
     * @param  string $uri
     * @param  string $json
     * @return mixed
     */
    private function patch(string $uri, $json)
    {
        $url = $this->apiUrl.'/'.$uri;
        $response = $this->client->patch($url, ['body' => $json])->getBody();
        return $this->serializer->deserialize($response, null, 'json');
    }

// createAlias($alias)

    /**
     * findAliasesForDomain.
     * @param  string $domainName
     * @param  string|null $query      an email address to look for
     * @return Alias[]
     */
    public function findAliasesForDomain(string $domainName, $query = null)
    {
        if (is_null($query)) {
            $uri = $domainName.'/aliases/';
        } else {
            $uri = $domainName.'/aliases/?q='.$query;
        }

        return $this->get($uri);
    }

    /**
     * findDomains.
     * @param  string|null       $query      a domain address to look for
     * @param  array|string|null $includes   string or array of includes e.g. ['mailboxes', 'aliases']
     * @return Domain[]
     */
    public function findDomains($query = null, $includes = null)
    {
        $uri = 'domains/?';
        if (! is_null($query)) {
            $uri .= 'q=' . $query;
        }
        if (! is_null($query) && ! is_null($includes)) {
            $uri .= '&';
        }
        if (! is_null($includes)) {
            $uri .= 'include=';
            if (is_string($includes)) {
                $uri .= $includes;
            } else {
                $uri .= implode(",", $includes);
            }
        }

        return $this->get($uri);
    }

    /**
     * findMailboxesForDomain.
     * @param  string $domainName
     * @param  string|null $query      an email address to look for
     * @return Mailbox[]
     */
    public function findMailboxesForDomain(string $domainName, $query = null)
    {
        if (is_null($query)) {
            $uri = $domainName.'/mailboxes/';
        } else {
            $uri = $domainName.'/mailboxes/?q='.$query;
        }

        return $this->get($uri);
    }

    /**
     * getAliasForDomain.
     * @param  string $domainName
     * @param  int    $aliasId
     * @return Alias
     */
    public function getAliasForDomain(string $domainName, int $aliasId)
    {
        $uri = $domainName.'/aliases/'.$aliasId ;

        return $this->get($uri);
    }
 
    /**
     * getDomain.
     * @param  int    $domainId
     * @param  array|string|null $includes   string or array of includes e.g. ['mailboxes', 'aliases']
     * @return Domain
     */
    public function getDomain(int $domainId, $includes = null)
    {
        $uri = 'domains/'.$domainId ;
        if (! is_null($includes)) {
            $uri .= '?include=';
            if (is_string($includes)) {
                $uri .= $includes;
            } else {
                $uri .= implode(",", $includes);
            }
        }

        return $this->get($uri);
    }

    /**
     * getMailboxForDomain.
     * @param  string $domainName
     * @param  int    $mailboxId
     * @return Mailbox
     */
    public function getMailboxForDomain(string $domainName, int $mailboxId)
    {
        $uri = $domainName.'/mailboxes/'.$mailboxId ;

        return $this->get($uri);
    }

    /**
     * updateAlias.
     * @param  Alias $alias
     * @return Link
     */
    public function updateAlias(Alias $alias)
    {
        $uri = $alias->getDomain()->getDomain().'/aliases/'.$alias->getId();
        return $this->patch($uri, json_encode($alias));
    }

    /**
     * updateMailbox.
     * @param  Mailbox $mailbox
     * @return Link
     */
    public function updateMailbox(LWK\ViMbAdmin\Model\Mailbox $mailbox)
    {
        $uri = $mailboxes->getDomain()->getDomain().'/mailboxes/'.$mailbox->getId();
        return $this->patch($uri, json_encode($mailbox));
    }
}
