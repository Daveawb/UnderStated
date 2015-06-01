<?php namespace UnderStated\Examples\ClosureExample;

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
        return $builder->create()
            ->state('on', [
                ['flickSwitch' => function($state) { $state->transition('off'); }]
            ])
            ->state('off', [
                ['flickSwitch' => function($state) { $state->transition('on'); }]
            ], 1)
            ->transition('on', 'off', true)
            ->get(true);
    }
}