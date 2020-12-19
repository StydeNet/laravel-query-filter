<?php

namespace Styde\QueryFilter\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Styde\QueryFilter\Commands\FilterMakeCommand;
use Styde\QueryFilter\Commands\QueryMakeCommand;
use Styde\QueryFilter\Overrides\LengthAwarePaginator as CustomLengthAwarePaginator;

class QueryFilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FilterMakeCommand::class,
                QueryMakeCommand::class,
            ]);

            $this->mergeConfigFrom($this->packageRoot('config/query-filter.php'), 'query-filter');
        }

        $this->app->bind(LengthAwarePaginator::class, CustomLengthAwarePaginator::class);

        $this->loadTranslationsFrom($this->packageRoot('resources/lang'), 'query-filter');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //...
    }

    private function packageRoot(string $path): string
    {
        return __DIR__.'/../../'.$path;
    }
}
