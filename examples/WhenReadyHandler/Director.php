<?php namespace Examples\WhenReadyHandler;

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
            ->state('auto_setup', AutoSetupState::class)
            ->state('setup', SetupState::class, 1)
            ->state('ready', ReadyState::class)
            ->transition('auto_setup', 'ready')
            ->transition('setup', 'ready')
            ->get(false);
    }
}