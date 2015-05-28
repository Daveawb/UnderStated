<?php namespace FSM\Contracts;

use FSM\Machine;

/**
 * Interface MachineDriven
 * @package FSM\Contracts
 */
interface MachineDriven
{
    /**
     * Set the machine instance to the state
     *
     * @param Machine $machine
     * @return mixed
     */
    public function setMachine(Machine $machine);
}