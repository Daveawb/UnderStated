<?php

namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

/**
 * Class SecondState
 * @package UnderStated\Examples\ConstraintExample
 */
class SecondState extends State
{
    /**
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        /** @var StateMachine $machine */
        $machine = $this->machine;

        $machine->unGuard('second');

        if ($machine->checkReady()) {
            $this->transition('ready');
        }

        return parent::onEnter($state);
    }
}
