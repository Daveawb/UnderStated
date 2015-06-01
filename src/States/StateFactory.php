<?php namespace FSM\States;

use Closure;
use FSM\State;

/**
 * Class StateFactory
 * @package FSM\States
 */
class StateFactory
{
    /**
     * @param $id
     * @param $resolvable
     * @return State
     */
    public function create($id, $resolvable = null)
    {
        if (func_num_args() === 1)
            $resolvable = func_get_arg(0);

        if ($resolvable instanceof State)
            return $resolvable;

        if ($resolvable instanceof Closure)
            return $this->closureState($resolvable);

        $state = $this->getStateFromClass($resolvable);

        $state->setId($id);

        return $state;
    }

    /**
     * @param $resolvable
     * @return ClosureState
     */
    private function closureState($resolvable)
    {
        $state = new ClosureState();

        $state->addClosureTo('onEnter', $resolvable);

        return $state;
    }

    /**
     * @param $resolvable
     * @return mixed
     */
    private function getStateFromClass($resolvable)
    {
        $class = '\\' . ltrim($resolvable, '\\');

        return new $class();
    }
}
