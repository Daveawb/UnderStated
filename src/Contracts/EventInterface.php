<?php

namespace UnderStated\Contracts;

/**
 * Interface EventInterface
 * @package UnderStated\Contracts
 */
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
     */
    public function forget($names);
}
