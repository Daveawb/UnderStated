<?php namespace Examples\WhenReady;

use FSM\State;

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