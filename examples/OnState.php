<?php namespace Examples;

use FSM\State;

class OnState extends State
{
    public function onEnter()
    {
//        echo "On!\n";
    }

    public function flickSwitch()
    {
        $this->transition('off');
    }

    public function status()
    {
        echo "On!\n";
    }

    public function onExit()
    {
//        echo "Flicking the switch to off!\n";
    }
}