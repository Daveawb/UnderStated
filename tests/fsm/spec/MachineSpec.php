<?php

namespace spec\UnderStated;

use PhpSpec\ObjectBehavior;
use UnderStated\Adapters\GraphStructure;
use UnderStated\Contracts\EventInterface;
use UnderStated\Contracts\StructureInterface;
use UnderStated\Exceptions\UninitialisedException;
use UnderStated\States\State;

class MachineSpec extends ObjectBehavior
{
    function let(EventInterface $eventInterface)
    {
        $this->beConstructedWith($eventInterface);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UnderStated\Machine');
    }

    function it_should_throw_uninitialised_exception()
    {
        $this->shouldThrow(UninitialisedException::class)->during('transition', ['next_state', []]);
        $this->shouldThrow(UninitialisedException::class)->during('handle', ['handler', []]);
    }

    function it_should_set_an_id()
    {
        $this->setId('id');
    }

    function it_should_get_an_id()
    {
        $this->getId()->shouldReturn('machine');

        $this->setId('id');

        $this->getId()->shouldReturn('id');
    }

    function it_should_set_a_structure(StructureInterface $interface)
    {
        $this->setStructure($interface);
    }

    function it_should_get_the_structure(StructureInterface $interface)
    {
        $this->setStructure($interface);

        $this->getStructure()->shouldReturn($interface);
    }

    function it_should_set_an_active_state(State $state)
    {
        $this->setState($state);
    }

    function it_should_get_the_active_state(State $state)
    {
        $this->setState($state);

        $this->getState()->shouldReturn($state);
    }

    function it_should_get_state_history()
    {
        $this->getHistory()->shouldReturn([]);
    }

    function it_should_initialise(GraphStructure $structure, State $state)
    {
        $state->onEnter($state)->shouldBeCalled()->willReturn(true);

        $structure->getInitialState(null)->shouldBeCalled()->willReturn($state);

        $this->setStructure($structure);

        $this->initialise();
    }

    function it_should_transition(GraphStructure $structure, State $state)
    {
        $state->getId()
            ->shouldBeCalledTimes(1)
            ->willReturn('state');

        $state->onExit($state)->shouldBeCalled()->willReturn(true);
        $state->onEnter($state)->shouldBeCalled()->willReturn(true);
        $state->getBoundEvents()->shouldBeCalled()->willReturn([]);

        $this->setState($state);

        $structure->canTransitionFrom('state', 'new_state')
            ->shouldBeCalled()
            ->willReturn(true);

        $structure->getState('new_state')->shouldBeCalled()->willReturn($state);
        $structure->getState('state')->shouldBeCalled()->willReturn($state);

        $this->setStructure($structure);

        $this->transition('new_state')
            ->shouldBe(true);
    }

    function it_should_handle_state_methods(State $state)
    {
        $state->onExit($state)->shouldBeCalled()->willReturn(true);

        $this->setState($state);

        $this->handle('onExit', []);
    }

    function it_should_fire_events()
    {
        $this->fire('transition', []);
    }

    function it_should_register_event_listeners()
    {
        $this->listen('transition', function() {});
    }

    function it_should_forget_event_listeners()
    {
        $this->forget('event');

        $this->forget(['event1', 'event2']);
    }
}
