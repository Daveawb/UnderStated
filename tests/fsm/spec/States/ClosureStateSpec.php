<?php

namespace spec\FSM\States;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClosureStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSM\States\ClosureState');
    }

    function it_should_add_a_closure()
    {
        $this->addClosureTo('onEnter', function() { return 'test'; });
    }
}
