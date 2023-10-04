<?php

namespace LWK\ViMbAdmin\Contracts;

use Sainsburys\Guzzle\Oauth2\GrantType\GrantTypeInterface;

interface TokenStore
{
    /**
     * Find a token by key.
     * @param  string $key
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken|null
     */
    public function findByKey($key);

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DateTime $expires
     * @param  string $type
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public function create(string $key, string $token, \DateTime $expires, string $type);

    /**
     * Save token to storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token [description]
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public function save(ViMbAdminToken $token);

    /**
     * Remove a token from storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token
     */
    public function forget(ViMbAdminToken $token);

    /**
     * Litle helper to turn GrantType into a key.
     * @param  GrantTypeInterface $grantType
     * @return string
     */
    public function serializeKey(GrantTypeInterface $grantType);
}
