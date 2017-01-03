<?php

namespace LWK\ViMbAdmin\Contracts;

interface ViMbAdminToken
{
    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @param  string $type
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    static public function createToken($key, $token, $expires, $type);

    /**
     * Gets the value of id.
     *
     * @return int
     */
    public function getId();

    /**
     * Gets the value of key.
     *
     * @return string
     */
    public function getKey();

    /**
     * Sets the value of key.
     *
     * @param string $key the key
     *
     * @return self
     */
    public function setKey($key);

    /**
     * Gets the value of token.
     *
     * @return string
     */
    public function getToken();

    /**
     * Sets the value of token.
     *
     * @param string $token the token
     *
     * @return self
     */
    public function setToken($token);

    /**
     * Gets the value of expires.
     *
     * @return \DateTime|null
     */
    public function getExpires();

    /**
     * Sets the value of expires.
     *
     * @param \DateTime|null $expires the expires
     *
     * @return self
     */
    public function setExpires($expires);

    /**
     * Gets the value of type.
     *
     * @return string
     */
    public function getType();

    /**
     * Sets the value of type.
     *
     * @param string $type the type
     *
     * @return self
     */
    public function setType($type);
}
