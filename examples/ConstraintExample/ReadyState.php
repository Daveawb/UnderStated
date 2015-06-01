<?php namespace Examples\ConstraintExample;

use FSM\States\State;

/**
 * Class ReadyState
 * @package Examples\WhenReady
 */
class ReadyState extends State
{
    /**
     * If the FSM is not ready for this state
     * return false and stop transition.
     *
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        return $this->machine->checkReady();
    }
}