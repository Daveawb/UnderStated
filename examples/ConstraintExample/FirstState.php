<?php

namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

/**
 * Class FirstState
 * @package UnderStated\Examples\ConstraintExample
 */
class FirstState extends State
{
    /**
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        /** @var StateMachine $machine */
        $machine = $this->machine;

        $machine->unGuard('first');

        if ($machine->checkReady()) {
            $this->transition('ready');
        }

        return parent::onEnter($state);
    }
}
