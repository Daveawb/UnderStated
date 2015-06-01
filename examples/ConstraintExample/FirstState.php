<?php namespace Examples\ConstraintExample;

use FSM\States\State;

class FirstState extends State {

    public function onEnter()
    {
        $this->machine->unGuard('first');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}