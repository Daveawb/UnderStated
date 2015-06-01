<?php namespace UnderStated\Contracts;

use UnderStated\Machine;

/**
 * Interface MachineBuilder
 * @package FSM\Contracts
 */
interface MachineBuilder
{
    /**
     * Create a new FSM instance
     *
     * @param Machine $machine
     *
     * @return $this
     */
    public function create(Machine $machine = null);

    /**
     * Add a new state
     *
     * @param $id
     * @param $resolvable
     * @param int $location
     * @return $this
     */
    public function state($id, $resolvable = null, $location = 0);

    /**
     * Add a list of states
     *
     * @param array $states
     * @return mixed
     */
    public function states(array $states);

    /**
     * Add a new transition
     *
     * @param $fromId
     * @param $toId
     * @param int $undirected
     * @return $this
     */
    public function transition($fromId, $toId, $undirected = 0);

    /**
     * Add a list of transitions
     *
     * @param array $transitions
     * @return mixed
     */
    public function transitions(array $transitions);

    /**
     * Get the built machine
     *
     * @return Machine
     */
    public function get();
}