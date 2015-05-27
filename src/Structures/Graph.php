<?php namespace FSM\Structures;

use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\ComponentInterface;
use FSM\Contracts\StateInterface;
use FSM\Contracts\StructureInterface;

/**
 * Class Graph
 * @package FSM\Structures
 */
class Graph implements StructureInterface, ComponentInterface
{
    /**
     * @var \FSM\Contracts\Machine\MachineInterface
     */
    private $machine;

    /**
     * @var \Fhaculty\Graph\Graph
     */
    private $graph;

    /**
     * Create a new instance of this structure
     */
    public function __construct()
    {
        $this->graph = new \Fhaculty\Graph\Graph();
    }

    /**
     * @param MachineInterface $machine
     * @return void
     */
    public function FSM(MachineInterface $machine)
    {
        $this->machine = $machine;
    }

    /**
     * @param StateInterface $state
     * @param $initial
     * @return void
     */
    public function addState(StateInterface $state, $initial)
    {
        $this->graph->createVertex($state->state());

        if ( $initial )
        {
            $this->machine->setState($state);
        }
    }
}
