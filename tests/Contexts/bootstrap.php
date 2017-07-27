<?php

use UnderStated\Adapters\GraphStructure;
use UnderStated\Adapters\LaravelEvents;
use UnderStated\Contracts\EventInterface;
use UnderStated\Contracts\StructureInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider;

require_once __DIR__ . '/../../vendor/autoload.php';

if ( ! function_exists('app'))
{
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return Illuminate\Container\Container
     */
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) return Container::getInstance();
        return Container::getInstance()->makeWith($make, $parameters);
    }
}

$app = new Container();
$app->setInstance($app);

$events = new EventServiceProvider($app);
$events->register();

$app->bind(Dispatcher::class, function($app)
{
    return $app['events'];
});

$app->bind(StructureInterface::class, function($app)
{
    return $app->make(GraphStructure::class);
});

$app->bind(EventInterface::class, function($app)
{
    return $app->make(LaravelEvents::class);
});

return $app;