<?php

namespace Jsadways\DataApi\Providers;

use Illuminate\Support\ServiceProvider;
use Jsadways\DataApi\Core\Services\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Services\Cross\CrossService;

class DataApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $configPath = __DIR__ . '/../config/data_api.php';
        $this->mergeConfigFrom($configPath, 'data_api');

        $this->app->singleton(CrossContract::class, CrossService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $source = realpath($raw = __DIR__.'/../config/data_api.php') ?: $raw;
        $this->publishes([
            $source => config_path('data_api.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
