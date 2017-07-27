<?php

namespace UnderStated\Examples\OnOffExample;

use UnderStated\Contracts\MachineBuilder;
use UnderStated\Machine;
use UnderStated\States\State;

/**
 * Class Director
 * @package UnderStated\Examples\OnOffExample
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
            ->state('on', OnState::class)
            ->state('off', OffState::class, State::INITIAL)
            ->transition('on', 'off', true)
            ->getMachine();

        $machine->initialise();

        return $machine;
    }
}
