<?php namespace Examples\OnOff;

use FSM\State;

class OffState extends State
{
    public function flickSwitch()
    {
        $this->transition('on');
    }
}