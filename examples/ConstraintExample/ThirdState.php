<?php namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

class ThirdState extends State
{
    /**
     * @param State $state
     * @return bool|void
     */
    public function onEnter(State $state)
    {
        $this->machine->unGuard('third');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}