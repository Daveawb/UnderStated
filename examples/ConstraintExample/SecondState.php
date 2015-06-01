<?php namespace Examples\ConstraintExample;

use FSM\States\State;

class SecondState extends State {

    public function onEnter()
    {
        $this->machine->unGuard('second');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}