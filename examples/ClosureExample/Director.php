<?php

namespace UnderStated\Examples\ClosureExample;

use UnderStated\Contracts\MachineBuilder;
use UnderStated\Machine;
use UnderStated\States\State;

/**
 * Class Director
 * @package UnderStated\Examples\ClosureExample
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
            ->state('on', [
                ['flickSwitch' => function (State $state) {
                    $state->transition('off');
                }]
            ])
            ->state('off', [
                ['flickSwitch' => function (State $state) {
                    $state->transition('on');
                }]
            ], 1)
            ->transition('on', 'off', true)
            ->getMachine();

        $machine->initialise();

        return $machine;
    }
}
