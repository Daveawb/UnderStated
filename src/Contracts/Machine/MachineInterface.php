<?php namespace FSM\Contracts\Machine;

use FSM\Contracts\StateInterface;
use FSM\Contracts\StructureInterface;

/**
 * Interface MachineInterface
 * @package FSM\Contracts
 */
interface MachineInterface
{
    /**
     * Register a structure with the base machine.
     *
     * @param StructureInterface $structure
     * @return mixed
     */
    public function structure(StructureInterface $structure);

    /**
     * Register a state with the base machine.
     *
     * @param StateInterface $state
     * @param bool $initial
     * @return mixed
     */
    public function state(StateInterface $state, $initial = false);
}