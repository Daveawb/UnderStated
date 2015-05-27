<?php namespace FSM\Contracts\Machine;

interface Buildable {

    /**
     * Add a new state to the FSM
     *
     * @param $state
     * @return void
     */
    public function addState($state);

    /**
     * Add a new transition from one state to another
     *
     * @param $from
     * @param $to
     */
    public function addTransition($from, $to);

    /**
     * Set the initial state for the FSM
     *
     * @param $state
     * @return void
     */
    public function addInitialState($state);
}