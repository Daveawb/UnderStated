<?php

namespace FSM\States;

use Closure;
use FSM\State;

class ClosureState extends State
{
    /**
     * @var array
     */
    protected $closures = [];

    /**
     * @param $method
     * @param callable $closure
     */
    public function addClosureTo($method, Closure $closure)
    {
        $this->closures[$method][] = $closure;
    }
}
