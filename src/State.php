<?php namespace FSM;

use Fhaculty\Graph\Vertex;
use FSM\Contracts\MachineDriven;

abstract class State implements MachineDriven
{
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
     * @param Machine $machine
     * @return void
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;
    }

    /**
     * Set the graph vertex for this state.
     *
     * @param Vertex $vertex
     * @return void
     */
    public function setVertex(Vertex $vertex)
    {
        $this->vertex = $vertex;
    }

    /**
     * Get the class name or the state attribute as the states name
     *
     * @return string
     */
    public function getId()
    {
        if (isset($this->state)) return $this->state;

        $className = str_replace('\\', '', snake_case(class_basename($this)));

        return str_replace('_state', '', $className);
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
     * @param array  $args
     */
    public function handle($handle, $args = [])
    {
        $this->machine->handle($handle, $args);
    }
}