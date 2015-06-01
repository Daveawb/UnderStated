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
        if (func_num_args() === 1) {
            $resolvable = func_get_arg(0);
            $id = null;
        }

        if ($resolvable instanceof State)
            return $resolvable;

        if ($resolvable instanceof Closure)
            $state = $this->closureState($resolvable);

        if (is_array($resolvable))
            $state = $this->closureFromArray($resolvable);

        else
            $state = $this->getStateFromClass($resolvable);

        if ($id)
            $state->setId($id);

        return $state;
    }

    /**
     * @param $resolvable
     * @return ClosureState
     */
    private function closureState($resolvable)
    {
        $state = $this->newClosureState();

        $state->addClosure('onEnter', $resolvable);

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

    /**
     * @return ClosureState
     */
    private function newClosureState()
    {
        return new ClosureState();
    }

    private function closureFromArray($resolvable)
    {
        $state = $this->newClosureState();

        foreach($resolvable as $map)
        {
            if (is_array($map))
            {
                while(list($id, $closure) = each($map))
                {
                    $state->addClosure($id, $closure);
                }
            }
        }

        return $state;
    }
}
