<?php

namespace UnderStated\States;

use Closure;
use Fhaculty\Graph\Vertex;
use UnderStated\Contracts\MachineDriven;
use UnderStated\Machine;

/**
 * Class State
 * @package UnderStated\States
 */
class State implements MachineDriven
{
    /**
     * Initial state constant
     */
    const INITIAL = 1;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var Vertex
     */
    protected $vertex;

    /**
     * @var Machine
     */
    protected $machine;

    /**
     * @var array
     */
    protected $closures = [];

    /**
     * @var array
     */
    protected $boundEvents = [];

    /**
     * @param Machine $machine
     *
     * @return void
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;
    }

    /**
     * @return Machine
     */
    public function getMachine()
    {
        return $this->machine;
    }

    /**
     * Set the graph vertex for this state.
     *
     * @param Vertex $vertex
     *
     * @return void
     */
    public function setVertex(Vertex $vertex)
    {
        $this->vertex = $vertex;
    }

    /**
     * Get the graph vertex associated with this state
     *
     * @return Vertex
     */
    public function getVertex()
    {
        return $this->vertex;
    }

    /**
     * Get the state ID
     *
     * @return string
     */
    public function getId()
    {
        if (isset($this->state)) {
            return $this->state;
        }


        $className = str_replace('\\', '', snake_case(class_basename($this)));

        return $this->state = str_replace('_state', '', $className);
    }

    /**
     * Set the state ID
     *
     * @param string $state
     */
    public function setId($state)
    {
        $this->state = $state;
    }

    /**
     * Get the bound events on the state
     *
     * @return array
     */
    public function getBoundEvents()
    {
        return $this->boundEvents;
    }

    /**
     * Helper function to transition to a new state.
     *
     * @param string $state
     */
    public function transition($state)
    {
        $this->machine->transition($state);
    }

    /**
     * Helper function to handle a state method.
     *
     * @param string $handle
     * @param array $args
     *
     * @return mixed
     */
    public function handle($handle, $args = [])
    {
        return $this->machine->handle($handle, $args);
    }

    /**
     * @param $event
     * @param array $args
     */
    public function fire($event, $args = [])
    {
        $this->machine->fire($event, $args);
    }

    /**
     * @param $event
     * @param $callback
     */
    public function listen($event, $callback)
    {
        $this->boundEvents[] = $event;

        $this->machine->listen($event, $callback);
    }

    /**
     * Forget bound events
     *
     * @param $events
     */
    public function forget($events)
    {
        $this->machine->forget($events);
    }

    /**
     * @param string $method
     * @param Closure $closure
     */
    public function addClosure($method, Closure $closure)
    {
        $this->closures[$method] = $closure;
    }

    /**
     * onEnter handler for state.
     *
     * @param State $state
     * @return bool
     */
    public function onEnter(State $state)
    {
        return true;
    }

    /**
     * onExit handler for state
     *
     * @param State $state
     * @return bool
     */
    public function onExit(State $state)
    {
        return true;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (array_key_exists($method, $this->closures)) {
            array_unshift($args, $this);
            return call_user_func_array($this->closures[$method], $args);
        }

        return null;
    }
}
