<?php namespace FSM\Contracts\Machine;
use FSM\Contracts\StateInterface;

/**
 * Interface BuilderInterface
 * @package FSM\Contracts\Machine
 */
interface BuilderInterface {
    /**
     * Add a new state
     *
     * @param \FSM\Contracts\StateInterface $state
     * @param bool $initial
     * @return $this
     */
    public function addState(StateInterface $state, $initial = false);

    /**
     * Add a transition from one state to another
     *
     * @param string $from
     * @param string $to
     * @param bool $reverse
     * @return $this
     */
    public function addTransition($from, $to, $reverse = false);

    /**
     * Get the state machine instance
     *
     * @return Buildable
     */
    public function getMachine();
}