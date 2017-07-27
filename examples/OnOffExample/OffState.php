<?php

namespace UnderStated\Examples\OnOffExample;

use UnderStated\States\State;

/**
 * Class OffState
 * @package UnderStated\Examples\OnOffExample
 */
class OffState extends State
{
    public function flickSwitch()
    {
        $this->transition('on');
    }
}
