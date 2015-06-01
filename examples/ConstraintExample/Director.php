<?php namespace UnderStated\Examples\ConstraintExample;

use UnderStated\Contracts\MachineBuilder;

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
        return $builder->create(app()->make(FSM::class))
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
    }
}