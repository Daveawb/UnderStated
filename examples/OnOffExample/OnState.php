<?php namespace Examples\OnOffExample;

use FSM\States\State;

class OnState extends State
{
    public function flickSwitch()
    {
        $this->transition('off');
    }
}