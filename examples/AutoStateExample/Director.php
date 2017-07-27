<?php

namespace UnderStated\Examples\AutoStateExample;

use UnderStated\Contracts\MachineBuilder;
use UnderStated\States\State;

/**
 * Class Director
 * @package UnderStated\Examples\AutoStateExample
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
            ->state('auto_setup', AutoSetupState::class, State::INITIAL)
            ->state('ready')
            ->transition('auto_setup', 'ready')
            ->getMachine();
    }
}
