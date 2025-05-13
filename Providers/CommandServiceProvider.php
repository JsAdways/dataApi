<?php

namespace Jsadways\DataApi\Providers;

use Illuminate\Support\ServiceProvider;
use Jsadways\DataApi\Console\Commands\API\ListCommand;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ListCommand::class
            ]);
        }
    }
}
