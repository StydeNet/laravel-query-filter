<?php

namespace Styde\LaravelQueryFilter;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Styde\LaravelQueryFilter\Commands\FilterMakeCommand;
use Styde\LaravelQueryFilter\Commands\QueryMakeCommand;

class LaravelQueryFilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([
                FilterMakeCommand::class,
                QueryMakeCommand::class,
            ]);

            // Publishing config.
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('query-filter.php'),
            ], 'config');
        }

        $this->app->bind(LengthAwarePaginator::class, \Styde\LaravelQueryFilter\Overrides\LengthAwarePaginator::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
    }
}
