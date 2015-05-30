<?php namespace Examples\WhenReady;

use FSM\State;

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