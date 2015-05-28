<?php namespace Examples;

use FSM\State;

class OffState extends State
{
    public function onEnter()
    {
//        echo "Off!\n";
    }

    public function status()
    {
        echo "Off!\n";
    }

    public function flickSwitch()
    {
        $this->transition('on');
    }
}