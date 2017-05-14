<?php

namespace LWK\ViMbAdmin;

use Illuminate\Support\Manager;
use LWK\ViMbAdmin\Model\DoctrineToken;
use LWK\ViMbAdmin\Driver\JsonTokenStore;
use LWK\ViMbAdmin\Driver\DoctrineTokenStore;
use LWK\ViMbAdmin\Driver\EloquentTokenStore;

class TokenStoreManager extends Manager
{
    /**
     * Create an instance of the JSON driver.
     *
     * @return JsonTokenStore
     */
    protected function createJsonDriver()
    {
        return new JsonTokenStore($this->app);
    }

    /**
     * Create an instance of the Eloquent driver.
     *
     * @return EloquentTokenStore
     */
    protected function createEloquentDriver()
    {
        return new EloquentTokenStore($this->app);
    }

    /**
     * Create an instance of the Doctrine driver.
     *
     * @return DoctrineTokenStore
     */
    protected function createDoctrineDriver()
    {
        return new DoctrineTokenStore($this->app['em'], $this->app['em']->getClassMetaData(DoctrineToken::class));
    }

    /**
     * Get the default driver.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['vimbadmin.driver'];
    }
}
