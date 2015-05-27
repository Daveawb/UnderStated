<?php namespace FSM\Contracts;

use FSM\Contracts\Machine\MachineInterface;

/**
 * Interface ComponentInterface
 * @package FSM\Contracts
 */
interface ComponentInterface
{
    /**
     * @param MachineInterface $machine
     * @return void
     */
    public function FSM(MachineInterface $machine);
}