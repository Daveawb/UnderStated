<?php

namespace spec\FSM\Structures;

use Fhaculty\Graph\Graph;
use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\StateInterface;
use FSM\States\State;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GraphSpec extends ObjectBehavior
{
    public function let(Graph $graph)
    {
        $this->beConstructedWith($graph);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('FSM\Structures\Graph');
    }

    public function it_should_set_an_fsm_instance(MachineInterface $machine)
    {
        $this->FSM($machine);
    }

    public function it_should_set_a_state(State $state)
    {
        $this->addState($state, false);
    }
}
