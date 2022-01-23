<?php

namespace LWK\ViMbAdmin\Driver;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Storage;
use LWK\ViMbAdmin\Contracts\TokenStore as TokenStoreContract;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken;
use LWK\ViMbAdmin\Model\JsonToken;
use LWK\ViMbAdmin\Traits\SerializeKey;

class JsonTokenStore implements TokenStoreContract
{
    use SerializeKey;

    /**
     * In memory token store.
     * @var array
     */
    protected $tokens;

    /**
     * @var string
     */
    protected $tokenFile;

    /**
     * @var int
     */
    protected $nextId;

    /**
     * JsonTokenStore constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $config = $container['config']->get('vimbadmin.providers.json', []);
        $this->tokenFile = $config['file'];

        $this->loadTokens();
    }

    /**
     * load Tokens from json store on disk.
     */
    public function loadTokens()
    {
        $this->tokens = [];
        if (Storage::has($this->tokenFile)) {
            $tokens = json_decode(Storage::get($this->tokenFile), true);
            foreach ($tokens as $arrayId => $tokenArray) {
                $expires = \DateTime::createFromFormat(\DateTime::ISO8601, $tokenArray['expires']);
                $token = JsonToken::createToken($tokenArray['key'], $tokenArray['token'], $expires, $tokenArray['type']);
                $token->setId($tokenArray['id']);
                $this->nextId = max($this->nextId, $tokenArray['id']);
                $this->tokens[$arrayId] = $token;
            }
            $this->nextId++;
        }
    }

    /**
     * save tokens out to disk.
     */
    private function persistTokens()
    {
        Storage::put($this->tokenFile, json_encode($this->tokens, JSON_PRETTY_PRINT));
    }

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DateTime $expires
     * @param  string $type
     * @return LWK\ViMbAdmin\JsonToken
     */
    public function create(string $key, string $token, \DateTime $expires, string $type)
    {
        $_token = JsonToken::createToken($key, $token, $expires, $type);

        return $_token;
    }

    /**
     * Find a token by key.
     * @param  string $key
     * @return ViMbAdminToken|null
     */
    public function findByKey($key)
    {
        // find array index
        foreach ($this->tokens as $token) {
            if ($token->getKey() == $key) {
                return $token;
            }
        }

        return null;
    }

    /**
     * Save token to storage this does and updateOrCreate.
     * @param  ViMbAdminToken $token [description]
     * @return ViMbAdminToken
     */
    public function save(ViMbAdminToken $token)
    {
        $newId = $this->nextId;
        foreach ($this->tokens as $id => $_token) {
            if ($_token->getKey() == $token->getKey()) {
                $newId = $id;
            }
        }

        // if the ID is not set assign next in line
        if (is_null($token->getId())) {
            $token->setId($newId);
            if ($newId == $this->nextId) {
                $this->nextId++;
            }
        }
        // add the object to the array
        $this->tokens[$newId] = $token;
        $this->persistTokens();

        return $token;
    }

    /**
     * Remove a token from storage.
     * @param  ViMbAdminToken $token
     */
    public function forget(ViMbAdminToken $token)
    {
        foreach ($this->tokens as $id => $_token) {
            if ($_token->getId() == $token->getId()) {
                unset($this->tokens[$id]);
            }
        }
        $this->persistTokens();
    }
}
