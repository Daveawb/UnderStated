<?php namespace UnderStated\States;

use Closure;
use UnderStated\Exceptions\StateException;

/**
 * Class StateFactory
 * @package FSM\States
 */
class StateFactory
{
    /**
     * @param $id
     * @param $resolvable
     *
     * @return State
     *
     * @throws StateException
     */
    public function create($id, $resolvable = null)
    {
        if (func_num_args() === 1)
        {
            $resolvable = func_get_arg(0);
            $id = null;
        }

        if (is_null($id) && is_callable($resolvable))
        {
            throw new StateException('States as closures must have an ID.');
        }

        $state = $this->buildState($resolvable);

        if ($id) $state->setId($id);

        return $state;
    }

    /**
     * @param $resolvable
     * @return ClosureState|mixed
     */
    private function buildState($resolvable)
    {
        if ($resolvable instanceof Closure)
        {
            $state = $this->closureState($resolvable);
        }
        elseif (is_array($resolvable))
        {
            $state = $this->closureFromArray($resolvable);
        }
        elseif (is_null($resolvable))
        {
            $state = $this->newState();
        }
        else
        {
            $state = $this->newStateFromClass($resolvable);
        }

        return $state;
    }

    /**
     * @param $resolvable
     * @return State
     */
    private function closureState($resolvable)
    {
        $state = $this->newState();

        $state->addClosure('onEnter', $resolvable);

        return $state;
    }

    /**
     * @param $resolvable
     * @return State
     */
    private function closureFromArray($resolvable)
    {
        $state = $this->newState();

        foreach($resolvable as $map)
        {
            if (is_array($map))
            {
                foreach($map as $id => $closure)
                {
                    $state->addClosure($id, $closure);
                }
            }
        }

        return $state;
    }

    /**
     * @param $resolvable
     * @return mixed
     */
    private function newStateFromClass($resolvable)
    {
        $class = '\\' . ltrim($resolvable, '\\');

        return new $class();
    }

    /**
     * @return ClosureState
     */
    private function newState()
    {
        return new State();
    }
}
