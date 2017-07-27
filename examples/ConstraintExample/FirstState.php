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
        $this->machine->unGuard('first');

        if ($this->machine->checkReady()) {
            $this->transition('ready');
        }

        return parent::onEnter($state);
    }
}
