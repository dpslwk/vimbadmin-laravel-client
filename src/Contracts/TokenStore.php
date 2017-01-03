<?php

namespace LWK\ViMbAdmin\Contracts;

use LWK\ViMbAdmin\Contracts\ViMbAdminToken;

interface TokenStore
{
    /**
     * Find a token by key.
     * @param  string $key
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken|null
     */
    public function findByKey(string $key);

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @param string $type
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public function create(string $key, string $token, DataTime $expires, string $type);

    /**
     * Save token to storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token [description]
     * @return [type]                [description]
     */
    public function save(ViMbAdminToken $token);

    /**
     * Remove a token from storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token
     * @return [type]                [description]
     */
    public function forget(ViMbAdminToken $token);

}
