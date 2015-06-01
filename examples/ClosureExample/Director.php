<?php namespace Examples\ClosureExample;

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
            ->state('on', function($state)
            {
                $state->transition('off');
            })
            ->state('off', function($state) {
                // It's off now
            })
            ->transition('on', 'off')
            ->get(true);
    }
}