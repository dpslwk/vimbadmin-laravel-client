<?php

namespace LWK\ViMbAdmin;

use Illuminate\Support\Manager;
use LWK\ViMbAdmin\Driver\JsonTokenStore;
use LWK\ViMbAdmin\Driver\EloquentTokenStore;
use LWK\ViMbAdmin\Driver\DoctorineTokenStore;

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
     * Create an instance of the Doctorine driver.
     *
     * @return DoctorineTokenStore
     */
    protected function createDoctorineDriver()
    {
        return new DoctorineTokenStore($this->app);
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