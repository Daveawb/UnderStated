<?php namespace FSM\Adapters;

use FSM\State;

interface StructureInterface {

    /**
     * @param $id
     * @param State $state
     */
    public function setState($id, State $state);

    /**
     * @param string $state
     * @return State
     */
    public function getState($state);

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function canTransitionFrom($from, $to);

    /**
     * @param string $state
     * @return mixed
     */
    public function getTransitionsFrom($state);

    /**
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function createTransitionTo($from, $to);
}