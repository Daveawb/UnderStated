<?php

namespace spec\Examples\WhenReadyHandler;

use FSM\Machine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutoSetupStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Examples\WhenReadyHandler\AutoSetupState');
    }

    function it_should_progress_on_enter(Machine $machine)
    {
        $this->setMachine($machine);

        $machine->handle('haveCoffee', [])->shouldBeCalled();

        $this->onEnter();
    }

    function it_should_handle_methods(Machine $machine)
    {
        $machine->handle('test', [])->shouldBeCalled();

        $this->setMachine($machine);

        $this->handle('test');
    }

    function it_should_transition(Machine $machine)
    {
        $machine->transition('test', [])->shouldBeCalled();

        $this->setMachine($machine);

        $this->transition('test');
    }

    function it_should_not_transition_when_constraints_are_not_met(Machine $machine)
    {
        $this->setMachine($machine);

        $this->onExit()->shouldReturn(false);
    }

    function it_should_transition_on_success(Machine $machine)
    {
        $this->setMachine($machine);

        $machine->handle('haveCoffee', [])->shouldBeCalled();
        $machine->handle('readyUpLlamas', [])->shouldBeCalled();
        $machine->handle('releasePigeons', [])->shouldBeCalled();

        $machine->transition('ready', [])->shouldBeCalled();

        $this->onEnter();
        $this->haveCoffee();
        $this->readyUpLlamas();
        $this->releasePigeons();

        $this->onExit()->shouldReturn(true);
    }
}
