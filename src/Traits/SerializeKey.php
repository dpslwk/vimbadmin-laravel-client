<?php

namespace LWK\ViMbAdmin\Traits;

use QBNK\Guzzle\Oauth2\GrantType\GrantTypeInterface;

trait SerializeKey
{
    /**
     * Litle helper to turn GrantType into a key.
     * @param  GrantTypeInterface $grantType
     * @return string
     */
    public function serializeKey(GrantTypeInterface $grantType)
    {
        return md5(serialize($grantType->getConfig()));
    }
}
