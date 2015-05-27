<?php

namespace FSM\States;

use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\ComponentInterface;
use FSM\Contracts\StateInterface;

/**
 * Class State
 * @package FSM\States
 */
abstract class State implements StateInterface, ComponentInterface
{
    /**
     * @var MachineInterface
     */
    protected $machine;

    /**
     * @param MachineInterface $machine
     * @return void
     */
    public function FSM(MachineInterface $machine)
    {
        $this->machine = $machine;
    }

    /**
     * Return the states name.
     *
     * @return string
     */
    abstract public function state();

    /**
     * Return an array of transitions.
     *
     * @return array
     */
    abstract public function transitions();
}
