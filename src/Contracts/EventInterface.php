<?php namespace FSM\Contracts;


interface EventInterface
{
    /**
     * @param $name
     * @param callable $callback
     * @return mixed
     */
    public function listen($name, callable $callback);

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    public function fire($name, $args = []);

    /**
     * @param $names
     * @return mixed
     */
    public function forget($names);
}