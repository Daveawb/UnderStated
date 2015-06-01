<?php namespace FSM\States;

use Closure;
use Fhaculty\Graph\Vertex;
use FSM\Contracts\MachineDriven;
use FSM\Exceptions\InvalidStateMethodException;
use FSM\Machine;

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
        if (isset($this->state)) return $this->state;

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
     * Helper function to transition to a new state.
     *
     * @param string $state
     * @param array  $args
     */
    public function transition($state, $args = [])
    {
        $this->machine->transition($state, $args);
    }

    /**
     * Helper function to handle a state method.
     *
     * @param string $handle
     * @param array $args
     *
     * @return mixed|void
     */
    public function handle($handle, $args = [])
    {
        return $this->machine->handle($handle, $args);
    }

    /**
     * @param $method
     * @param callable $closure
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
        if (array_key_exists($method, $this->closures))
        {
            array_unshift($args, $this);

            return call_user_func_array($this->closures[$method], $args);
        }
    }
}