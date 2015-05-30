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
     * Get the class name or the state attribute as the states name
     *
     * @return mixed
     */
    public function getId()
    {
        if (isset($this->state)) return $this->state;

        $className = str_replace('\\', '', snake_case(class_basename($this)));

        return str_replace('_state', '', $className);
    }

    /**
     * @param Machine $machine
     * @return void
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;
    }

    public function setVertex(Vertex $vertex)
    {
        $this->vertex = $vertex;
    }

    public function transition($state)
    {
        $this->machine->transition($state);
    }

    public function handle($handle, $args)
    {
        $this->machine->handle($handle, $args);
    }
}