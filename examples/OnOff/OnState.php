<?php namespace Examples\OnOff;

use FSM\State;

class OnState extends State
{
    public function flickSwitch()
    {
        $this->transition('off');
    }
}