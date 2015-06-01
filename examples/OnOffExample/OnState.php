<?php namespace UnderStated\Examples\OnOffExample;

use UnderStated\States\State;

class OnState extends State
{
    public function flickSwitch()
    {
        $this->transition('off');
    }
}