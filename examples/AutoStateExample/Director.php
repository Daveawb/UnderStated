<?php namespace Examples\AutoStateExample;

use FSM\Contracts\MachineBuilder;
use FSM\States\State;

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
            ->state('auto_setup', AutoSetupState::class, State::INITIAL)
            ->state('ready')
            ->transition('auto_setup', 'ready')
            ->get(false);
    }
}