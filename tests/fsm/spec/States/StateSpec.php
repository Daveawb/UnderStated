<?php

namespace spec\UnderStated\States;

use Fhaculty\Graph\Vertex;
use UnderStated\Machine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnderStated\States\State');
    }

    function it_should_set_an_id()
    {
        $this->setId('new_id');
        $this->getId()->shouldReturn('new_id');
    }

    function it_should_get_an_id_from_class_name()
    {
        $this->getId()->shouldReturn('state');
    }

    function it_should_set_a_machine(Machine $machine)
    {
        $this->setMachine($machine);
    }

    function it_should_get_a_machine(Machine $machine)
    {
        $this->setMachine($machine);

        $this->getMachine()->shouldReturn($machine);
    }

    function it_should_set_a_vertex(Vertex $vertex)
    {
        $this->setVertex($vertex);
    }

    function it_should_get_its_vertex(Vertex $vertex)
    {
        $this->setVertex($vertex);

        $this->getVertex()->shouldReturn($vertex);
    }

    function it_should_get_bound_state_events()
    {
        $this->getBoundEvents()->shouldReturn([]);
    }

    function it_should_transition_to_another_state(Machine $machine)
    {
        $machine->transition('next_state')->shouldBeCalled();

        $this->setMachine($machine);

        $this->transition('next_state', ['arg']);
    }

    function it_should_call_a_handler(Machine $machine)
    {
        $machine->handle('handler', ['arg1' => 'argVal'])->shouldBeCalled()->willReturn("it worked");

        $this->setMachine($machine);

        $this->handle('handler', ['arg1' => 'argVal'])->shouldReturn("it worked");
    }

    function it_should_add_a_closure_method()
    {
        $this->addClosure('myHandle', function($state) {
            return 'test';
        });
    }

    function it_should_be_able_to_call_closures_as_methods()
    {
        $this->addClosure('myHandle', function($state) {
            return 'test';
        });

        $this->myHandle()->shouldReturn('test');
    }

    function it_should_return_null_on_invalid_handle_call()
    {
        $this->myNonExistantHandler()->shouldReturn(null);
    }

    function it_should_fire_events(Machine $machine)
    {
        $machine->fire('event', [])->shouldBeCalled();

        $this->setMachine($machine);

        $this->fire('event');
    }

    function it_should_register_event_listeners(Machine $machine)
    {
        $closure = function() {};

        $machine->listen('event', $closure)->shouldBeCalled();

        $this->setMachine($machine);

        $this->listen('event', $closure);
    }

    function it_should_unbind_event_listeners(Machine $machine)
    {
        $machine->forget('event')->shouldBeCalled();

        $this->setMachine($machine);

        $this->forget('event');
    }
}
