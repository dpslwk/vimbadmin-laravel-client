<?php

namespace LWK\ViMbAdmi\Driver;

use LWK\ViMbAdmin\Contracts\TokenStore as TokenStoreContract;

class JsonTokenStore implements TokenStoreContract
{
    /**
     * In memory token store
     * @var Array
     */
    protected $tokens;

    /**
     * @var stringpa
     */
    protected $tokenFile;

    /**
     * JsonTokenStore constructor.
     *
     */
    public function __construct($app)
    {
        $config = $app['config']->get('vimbadmin.providers.json', []);
        $this->tokenFile = $config['file'];

        if (Storage::has($this->tokenFile)) {
            $this->tokens = json_decode(Storage::get($this->tokenFile), true);
        } else {
            $this->tokens = [];
        }
    }

    private function persistTokens()
    {
        Storage::put($this->tokenFile, json_encode($this->tokens, JSON_PRETTY_PRINT));
    }

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @param  string $type
     * @return LWK\ViMbAdmin\JsonToken
     */
    public function create(string $key, string $token, DataTime $expires, string $type)
    {
        return JsonToken::createToken($key, $token, $expires, $type);
    }

    /**
     * Find a token by key.
     * @param  string $key
     * @return ViMbAdminToken|null
     */
    public function findByKey($key)
    {

    }

    /**
     * Save token to storage.
     * @param  ViMbAdminToken $token [description]
     * @return [type]                [description]
     */
    public function save(ViMbAdminToken $token)
    {
        // deserialise
    }

    /**
     * Remove a token from storage.
     * @param  ViMbAdminToken $token
     * @return [type]                [description]
     */
    public function forget(ViMbAdminToken $token)
    {

    }


}
