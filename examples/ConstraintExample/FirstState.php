<?php namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

class FirstState extends State
{
    /**
     * @param State $state
     * @return bool|void
     */
    public function onEnter(State $state)
    {
        $this->machine->unGuard('first');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}