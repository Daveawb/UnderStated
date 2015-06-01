<?php namespace Examples\OnOffExample;

use FSM\States\State;

class OffState extends State
{
    public function flickSwitch()
    {
        $this->transition('on');
    }
}