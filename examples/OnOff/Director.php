<?php namespace Examples\OnOff;

use FSM\Contracts\MachineBuilder;

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
            ->state('off', OffState::class, 1)
            ->transition('on', 'off', true)
            ->get(true);
    }
}