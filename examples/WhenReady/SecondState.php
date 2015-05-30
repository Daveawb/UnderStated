<?php namespace Examples\WhenReady;

use FSM\State;

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