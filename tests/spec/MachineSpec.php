<?php namespace spec\FSM;

use FSM\States\State;
use FSM\Structures\Graph;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MachineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSM\Machine');
    }

    function it_should_set_a_structure(Graph $structure)
    {
        $this->structure($structure);
    }

    function it_should_set_a_state(State $state, Graph $structure)
    {
        $this->structure($structure);
        $this->state($state);
    }
}
