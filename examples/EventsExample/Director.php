<?php

namespace UnderStated\Examples\EventsExample;

use UnderStated\Contracts\MachineBuilder;
use UnderStated\Machine;
use UnderStated\States\State;

/**
 * Class Director
 * @package UnderStated\Examples\EventsExample
 */
class Director
{
    /**
     * Build the machine
     *
     * @param MachineBuilder $builder
     * @return Machine
     */
    public function build(MachineBuilder $builder)
    {
        $machine = $builder->create()
            ->state('init', InitialState::class, State::INITIAL)
            ->state('ready', ReadyState::class)
            ->transition('init', 'ready')
            ->getMachine();

        $machine->initialise();

        return $machine;
    }
}
