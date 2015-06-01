<?php namespace UnderStated\Examples\OnOffExample;

use UnderStated\States\State;

class OffState extends State
{
    public function flickSwitch()
    {
        $this->transition('on');
    }
}