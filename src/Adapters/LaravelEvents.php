<?php namespace FSM\Adapters;

use Closure;
use FSM\Contracts\EventInterface;
use Illuminate\Contracts\Events\Dispatcher;

class LaravelEvents implements EventInterface
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $name
     * @param callable $callback
     * @return mixed
     */
    public function listen($name, Closure $callback)
    {
        $this->dispatcher->listen($name, $callback);
    }

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    public function emit($name, $args = [])
    {
        $this->dispatcher->fire($name, $args);
    }

    /**
     * @param $names
     * @return mixed
     */
    public function forget($names)
    {
        $this->dispatcher->forget($names);
    }
}