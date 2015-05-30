<?php namespace Examples\WhenReady;

use FSM\State;

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
     * @return boolean
     */
    public function onEnter()
    {
        return $this->machine->checkReady();
    }
}