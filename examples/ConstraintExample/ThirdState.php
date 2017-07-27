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
        $this->machine->unGuard('third');

        if ($this->machine->checkReady()) {
            $this->transition('ready');
        }

        return parent::onEnter($state);
    }
}