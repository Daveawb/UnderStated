<?php

namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

/**
 * Class ReadyState
 * @package Examples\WhenReady
 */
class ReadyState extends State
{
    /**
     * If the StateMachine is not ready for this state
     * return false and stop transition.
     *
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        parent::onEnter($state);

        /** @var StateMachine $machine */
        $machine = $this->machine;

        return $machine->checkReady();
    }
}
