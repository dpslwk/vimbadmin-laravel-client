<?php

namespace LWK\ViMbAdmin;

use Illuminate\Support\ServiceProvider;
use LWK\ViMbAdmin\Contracts\TokenStore;

class ViMbAdminServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getConfigPath() => config_path('vimbadmin.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $this->app->singleton(TokenStore::class, function ($app) {
            $tokenStoreManager = new TokenStoreManager($app);

            return $tokenStoreManager->driver();
        });
    }

    /**
     * Merge config.
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            $this->getConfigPath(), 'vimbadmin'
        );
    }

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return __DIR__ . '/../config/vimbadmin.php';
    }
}
