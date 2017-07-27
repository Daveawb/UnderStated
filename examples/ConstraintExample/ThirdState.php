<?php namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

/**
 * Class ThirdState
 * @package UnderStated\Examples\ConstraintExample
 */
class ThirdState extends State
{
    /**
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        /** @var StateMachine $machine */
        $machine = $this->machine;

        $machine->unGuard('third');

        if ($machine->checkReady()) {
            $this->transition('ready');
        }

        return parent::onEnter($state);
    }
}
