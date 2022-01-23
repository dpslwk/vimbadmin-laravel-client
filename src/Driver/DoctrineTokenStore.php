<?php

namespace LWK\ViMbAdmin\Driver;

use Doctrine\ORM\EntityRepository;
use LWK\ViMbAdmin\Model\DoctrineToken;
use LWK\ViMbAdmin\Traits\SerializeKey;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken;
use LWK\ViMbAdmin\Contracts\TokenStore as TokenStoreContract;

class DoctrineTokenStore extends EntityRepository implements TokenStoreContract
{
    use SerializeKey;

    /**
     * Find a token by key.
     * @param  string $key
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken|null
     */
    public function findByKey($key)
    {
        return parent::findOneByKey($key);
    }

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DateTime $expires
     * @param  string $type
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public function create(string $key, string $token, \DateTime $expires, string $type)
    {
        $_token = DoctrineToken::createToken($key, $token, $expires, $type);

        return $_token;
    }

    /**
     * Save token to storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token [description]
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    public function save(ViMbAdminToken $token)
    {
        $this->_em->persist($token);
        $this->_em->flush();
    }

    /**
     * Remove a token from storage.
     * @param  LWK\ViMbAdmin\Contracts\ViMbAdminToken $token
     */
    public function forget(ViMbAdminToken $token)
    {
        $this->_em->remove($token);
        $this->_em->flush();
    }
}
