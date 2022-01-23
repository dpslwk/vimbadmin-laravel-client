<?php

namespace LWK\ViMbAdmin\Middelware;

use GuzzleHttp\ClientInterface;
use LWK\ViMbAdmin\Contracts\TokenStore;
use QBNK\Guzzle\Oauth2\Middleware\OAuthMiddleware;
use QBNK\Guzzle\Oauth2\GrantType\GrantTypeInterface;
use QBNK\Guzzle\Oauth2\GrantType\RefreshTokenGrantTypeInterface;

class ViMbAdminOAuthMiddleware extends OAuthMiddleware
{
    /**
     * @var TokenStore
     */
    protected $tokenStore;

    /**
     * Create a new Oauth2 subscriber.
     *
     * @param ClientInterface                $client
     * @param GrantTypeInterface             $grantType
     * @param RefreshTokenGrantTypeInterface $refreshTokenGrantType
     * @param TokenStore                     $tokenStore
     */
    public function __construct(
        ClientInterface $client,
        GrantTypeInterface $grantType = null,
        RefreshTokenGrantTypeInterface $refreshTokenGrantType = null,
        TokenStore $tokenStore
    ) {
        $this->tokenStore = $tokenStore;
        parent::__construct($client, $grantType, $refreshTokenGrantType);
    }

    /**
     * Get a new access token.
     *
     * @return AccessToken|null
     */
    protected function acquireAccessToken()
    {
        parent::acquireAccessToken();

        $this->saveAccessToken();

        return $this->accessToken;
    }

    /**
     * Save new access token to out tokenStore.
     */
    private function saveAccessToken()
    {
        $key = $this->tokenStore->serializeKey($this->grantType);
        $token = $this->tokenStore->create(
            $key,
            $this->accessToken->getToken(),
            $this->accessToken->getExpires(),
            $this->accessToken->getType()
        );
        $this->tokenStore->save($token);
    }
}
