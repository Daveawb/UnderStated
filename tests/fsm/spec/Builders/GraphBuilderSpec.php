<?php

namespace spec\UnderStated\Builders;

use UnderStated\Machine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GraphBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnderStated\Builders\GraphBuilder');
    }

    function it_creates_a_new_machine(Machine $machine)
    {
        $this->create($machine);
    }

    function it_adds_a_state(Machine $machine)
    {
        $this->create($machine);

        $closure = function() {
            return 'test';
        };

        $this->state('test', $closure);
    }

    function it_adds_multiple_states(Machine $machine)
    {
        $states = [
            ['test', $c1 = function() { return 'test'; }],
            ['test2', $c2 = function() { return 'test2'; }]
        ];

        $this->create($machine);

        $this->states($states);
    }

    function it_adds_a_transition(Machine $machine)
    {
        $states = [
            ['test', $c1 = function() { return 'test'; }],
            ['test2', $c2 = function() { return 'test2'; }]
        ];

        $this->create($machine);

        $this->states($states);

        $this->transition('test', 'test2');
    }

    function it_adds_multiple_transitions(Machine $machine)
    {
        $transitions = [
            ['test', 'test2'],
            ['test2', 'test']
        ];

        $states = [
            ['test', $c1 = function() { return 'test'; }],
            ['test2', $c2 = function() { return 'test2'; }]
        ];

        $this->create($machine);

        $this->states($states);

        $this->transitions($transitions);
    }

    function it_gets_a_built_machine(Machine $machine)
    {
        $this->create($machine);

        $this->get()->shouldBeAnInstanceOf(Machine::class);
    }
}
