<?php

namespace UnderStated\Contracts;

use UnderStated\Machine;

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
     */
    public function setMachine(Machine $machine);
}
