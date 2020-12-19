<?php

namespace Styde\QueryFilter;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Styde\QueryFilter\Commands\FilterMakeCommand;
use Styde\QueryFilter\Commands\QueryMakeCommand;

class QueryFilterServiceProvider extends ServiceProvider
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

        $this->app->bind(LengthAwarePaginator::class, \Styde\QueryFilter\Overrides\LengthAwarePaginator::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'query-filter');
    }
}
