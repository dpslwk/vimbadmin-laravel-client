<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMbAdmin\Traits\Token;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken as ViMbAdminTokenContract;

class DoctorineToken implements ViMbAdminTokenContract
{
    use Token;

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    static public function createToken($key, $token, $expires, $type)
    {
        $_token = new static();
        $_token->key = $key;
        $_token->token = $token;
        $_token->expires = $expires;
        $_token->type = $type;
        return $_token;
    }

}
