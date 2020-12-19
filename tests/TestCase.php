<?php

namespace Styde\QueryFilter\Tests;

use Orchestra\Testbench\Concerns\WithLoadMigrationsFrom;
use Orchestra\Testbench\TestCase as Orchestra;
use Styde\QueryFilter\QueryFilterServiceProvider;

class TestCase extends Orchestra
{
    use WithLoadMigrationsFrom, TestHelpers;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /*
         * Load migrations
         */
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [QueryFilterServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        /** Config */
        $app['config']->set('query-filter.up', 'fas fa-sort-up');
        $app['config']->set('query-filter.down', 'fas fa-sort-down');
        $app['config']->set('query-filter.sort', 'fas fa-sort');

        /** Database */
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
