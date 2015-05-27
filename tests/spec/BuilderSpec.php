<?php namespace spec\FSM;

use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\StructureInterface;
use FSM\Machine;
use FSM\States\State;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderSpec extends ObjectBehavior
{
    function let(MachineInterface $machine, StructureInterface $structure)
    {
        $this->beConstructedWith($machine, $structure);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSM\Builder');
    }

    function it_should_add_states(State $state)
    {
        $this->addState($state);
    }
}
