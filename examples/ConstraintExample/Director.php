<?php

namespace UnderStated\Examples\ConstraintExample;

use UnderStated\Contracts\MachineBuilder;

/**
 * Class Director
 * @package UnderStated\Examples\ConstraintExample
 */
class Director
{
    /**
     * Build the machine
     *
     * @param MachineBuilder $builder
     * @return StateMachine
     */
    public function build(MachineBuilder $builder)
    {
        /** @var StateMachine $machine */
        $machine = $builder->create(app()->make(StateMachine::class))
            ->state('first', FirstState::class)
            ->state('second', SecondState::class)
            ->state('third', ThirdState::class)
            ->state('ready', ReadyState::class)
            ->transition('first', 'second', true)
            ->transition('first', 'third', true)
            ->transition('second', 'third', true)
            ->transition('first', 'ready')
            ->transition('second', 'ready')
            ->transition('third', 'ready')
            ->get(false);

        return $machine;
    }
}
