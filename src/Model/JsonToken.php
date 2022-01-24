<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMbAdmin\Traits\Token;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken as ViMbAdminTokenContract;

class JsonToken implements ViMbAdminTokenContract, \JsonSerializable
{
    use Token;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public static function createToken($key, $token, $expires, $type)
    {
        $_token = new static();
        $_token->key = $key;
        $_token->token = $token;
        $_token->expires = $expires;
        $_token->type = $type;

        return $_token;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'token' => $this->token,
            'expires' => $this->expires->format(\DateTime::ISO8601),
            'type' => $this->type,
        ];
    }
}
