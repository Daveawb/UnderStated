<?php namespace UnderStated\Examples\EventsExample;

use UnderStated\Contracts\MachineBuilder;
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
     * @return mixed
     */
    public function build(MachineBuilder $builder)
    {
        return $builder->create()
            ->state('init', InitialState::class, State::INITIAL)
            ->state('ready', ReadyState::class)
            ->transition('init', 'ready')
            ->get(true);
    }
}
