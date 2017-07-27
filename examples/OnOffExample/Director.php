<?php

namespace UnderStated\Examples\OnOffExample;

use UnderStated\Contracts\MachineBuilder;
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
     * @return mixed
     */
    public function build(MachineBuilder $builder)
    {
        return $builder->create()
            ->state('on', OnState::class)
            ->state('off', OffState::class, State::INITIAL)
            ->transition('on', 'off', true)
            ->get(true);
    }
}
