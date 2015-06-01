<?php namespace FSM\States;

use Closure;

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
        {
            $resolvable = func_get_arg(0);
            $id = null;
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
            $state = $this->newClosureState();
        }
        else
        {
            $state = $this->getStateFromClass($resolvable);
        }

        return $state;
    }

    /**
     * @param $resolvable
     * @return State
     */
    private function closureState($resolvable)
    {
        $state = $this->newClosureState();

        $state->addClosure('onEnter', $resolvable);

        return $state;
    }

    /**
     * @param $resolvable
     * @return State
     */
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
        return new State();
    }
}
