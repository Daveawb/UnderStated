<?php

namespace UnderStated\Examples\OnOffExample;

use UnderStated\States\State;

/**
 * Class OnState
 * @package UnderStated\Examples\OnOffExample
 */
class OnState extends State
{
    public function flickSwitch()
    {
        $this->transition('off');
    }
}
