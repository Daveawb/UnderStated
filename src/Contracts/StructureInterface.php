<?php namespace FSM\Contracts;

/**
 * Interface StructureInterface
 * @package FSM\Contracts
 */
interface StructureInterface
{
    /**
     * @param StateInterface $state
     * @param $initial
     * @return void
     */
    public function addState(StateInterface $state, $initial);
}