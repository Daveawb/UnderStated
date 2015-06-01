<?php namespace Examples\ConstraintExample;

use FSM\States\State;

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