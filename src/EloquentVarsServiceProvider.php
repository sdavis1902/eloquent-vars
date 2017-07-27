<?php
namespace sdavis1902\EloquentVars;

use Exception;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class EloquentVarsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->prepareResources();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Publish migrations
        $migrations = realpath(__DIR__.'/migrations/');

        $this->publishes([
            $migrations => database_path('migrations')
        ], 'migrations');
    }
}
