<?php

namespace LWK\ViMbAdmin;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
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
    protected $tokenStore;
    protected $apiUrl;
    protected $clientId;
    protected $clientSecret;
    protected $client;
    protected $normalizer;
    protected $serializer;

    function __construct(TokenStore $tokenStore, \Illuminate\Config\Repository $config, ViMbAdminNormalizer$normalizer)
    {
        $this->tokenStore = $tokenStore;
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

    public function setupClient($apiUrl, $clientId, $clientSecret, $tokenUri = '/oauth/token')
    {
        $handlerStack = HandlerStack::create();
        $client = new Client(
            [
                'handler'=> $handlerStack,
                'base_uri' => $apiUrl,
                'auth' => 'oauth2',
                'headers' => [
                    'Accept'     => 'application/json',
                ],
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
    }

    public function get($url)
    {
        // return json_decode($this->client->get($url)->getBody());
        return $this->serializer->deserialize($this->client->get($url)->getBody(), Mailbox::class, 'json');
    }

// createAlias($alias)
// findAliasesForDomain($domainName, $query)
// findDomains($query, $includes)
// findMailboxesForDoman($domainName, $query)
// getAliasForDomain($domainName, $aliasId)
// getDomain($domainId)
// getMailboxForDomain($domainName, $mailboxId)
// requestToken()
// updateAlias($alias)
// updateMailbox($mailbox)



}
