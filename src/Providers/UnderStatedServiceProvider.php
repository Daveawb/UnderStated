<?php

namespace UnderStated\Providers;

use Illuminate\Support\ServiceProvider;


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
            \UnderStated\Contracts\EventInterface::class,
            \UnderStated\Adapters\LaravelEvents::class
        );

    }
}
