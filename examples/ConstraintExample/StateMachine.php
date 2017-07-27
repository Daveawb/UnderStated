<?php

namespace UnderStated\Examples\ConstraintExample;

use UnderStated\Machine;

/**
 * Class StateMachine
 * @package UnderStated\Examples\ConstraintExample
 */
class StateMachine extends Machine
{
    /**
     * @var array
     */
    protected $constraints = [
        'first' => false,
        'second' => false,
        'third' => false
    ];

    /**
     * @return bool
     */
    public function checkReady()
    {
        return count(array_keys($this->constraints, true)) === count($this->constraints);
    }

    /**
     * @param $state
     */
    public function unGuard($state)
    {
        $this->constraints[$state] = true;
    }
}
