<?php

namespace spec\UnderStated\States;

use UnderStated\Exceptions\StateException;
use UnderStated\States\State;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnderStated\States\StateFactory');
    }

    function it_creates_a_closure_state_with_an_id()
    {
        $this->create('test', function() { return 'test'; })->shouldBeAnInstanceOf(State::class);
    }

    function it_does_not_create_a_closure_state_with_no_id()
    {
        $this->shouldThrow(StateException::class)->during('create', [function() { return 'test'; }]);
    }

    function it_creates_a_state_from_a_class_name()
    {
        $this->create(State::class)->shouldBeAnInstanceOf(State::class);
    }

    function it_creates_a_state_with_an_id()
    {
        $this->create('test', State::class)->shouldBeAnInstanceOf(State::class);
    }
}
