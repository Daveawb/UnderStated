<?php

namespace spec\FSM\States;

use FSM\State;
use FSM\States\ClosureState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSM\States\StateFactory');
    }

    function it_creates_a_closure_state()
    {
        $this->create(function() { return 'test'; })->shouldBeAnInstanceOf(ClosureState::class);
    }

    function it_creates_a_state_from_a_class_name()
    {
        $this->create(ClosureState::class)->shouldBeAnInstanceOf(State::class);
    }

    function it_create_a_state_with_an_id()
    {
        $this->create('test', ClosureState::class)->shouldBeAnInstanceOf(State::class);
    }
}
