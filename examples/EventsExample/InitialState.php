<?php namespace UnderStated\Examples\EventsExample;

use UnderStated\States\State;

class InitialState extends State
{
    public function onEnter(State $state)
    {
        $this->listen('check' , function($fsm)
        {
            $fsm->transition('ready');
        });
    }
}
