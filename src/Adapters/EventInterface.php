<?php namespace FSM\Adapters;

use Closure;

interface EventInterface
{
    /**
     * @param $name
     * @param callable $callback
     * @return mixed
     */
    public function listen($name, Closure $callback);

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    public function emit($name, $args = []);
}