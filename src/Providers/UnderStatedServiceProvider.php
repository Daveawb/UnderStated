<?php

namespace UnderStated\Providers;

use Illuminate\Support\ServiceProvider;
use UnderStated\Adapters\LaravelEvents;
use UnderStated\Contracts\EventInterface;

/**
 * Class UnderStatedServiceProvider
 * @package UnderStated\Providers
 */
class UnderStatedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EventInterface::class,
            LaravelEvents::class
        );
    }
}
