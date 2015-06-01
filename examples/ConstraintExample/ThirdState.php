<?php namespace Examples\ConstraintExample;

use FSM\States\State;

class ThirdState extends State{

    public function onEnter()
    {
        $this->machine->unGuard('third');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}