<?php

namespace spec\FSM\States;

use Fhaculty\Graph\Vertex;
use FSM\Machine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSM\States\State');
    }

    function it_should_set_an_id()
    {
        $this->setId('newid');
        $this->getId()->shouldReturn('newid');
    }

    function it_should_get_an_id_from_classname()
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

        $this->getVertex($vertex)->shouldReturn($vertex);
    }

    function it_should_transition_to_another_state(Machine $machine)
    {
        $machine->transition('nextstate', ['arg'])->shouldBeCalled();

        $this->setMachine($machine);

        $this->transition('nextstate', ['arg']);
    }

    function it_should_call_a_handler(Machine $machine)
    {
        $machine->handle('handler', ['arg1' => 'argVal'])->shouldBeCalled();

        $this->setMachine($machine);

        $this->handle('handler', ['arg1' => 'argVal']);
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
}
