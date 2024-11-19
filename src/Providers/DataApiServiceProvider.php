<?php

namespace Jsadways\DataApi\Providers;

use Illuminate\Support\ServiceProvider;

class DataApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $configPath = __DIR__ . '/../../config/data_api.php';
        $this->mergeConfigFrom($configPath, 'data_api');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}
