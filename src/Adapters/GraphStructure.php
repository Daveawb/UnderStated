<?php namespace FSM\Adapters;

use Fhaculty\Graph\Graph;
use FSM\Contracts\MachineDriven;
use FSM\Contracts\StructureInterface;
use FSM\Machine;
use FSM\States\State;

class GraphStructure implements StructureInterface, MachineDriven
{
    /**
     * @var Machine
     */
    protected $machine;

    /**
     * @param Graph $graph
     */
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    /**
     * @param $id
     * @param State $state
     * @param int $location
     */
    public function addState($id, State $state, $location = 0)
    {
        if ($this->graph->getVertices()->isEmpty() || $location === 1)
            $this->initial = $id;

        $vertex = $this->graph->createVertex($id);

        $vertex->setAttribute('state', $state);

        $state->setVertex($vertex);

        $state->setMachine($this->machine);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getState($id)
    {
        return $this->getVertex($id)->getAttribute('state');
    }

    /**
     * @param $id
     * @return \Fhaculty\Graph\Vertex
     */
    protected function getVertex($id)
    {
        return $this->graph->getVertex($id);
    }

    /**
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function canTransitionFrom($from, $to)
    {
        return $this->getVertex($from)
            ->hasEdgeTo($this->getVertex($to));
    }

    /**
     * @param string $state
     * @return array
     */
    public function getTransitionsFrom($state)
    {
        return $this->getVertex($state)
            ->getVerticesEdgeTo()
            ->getIds();
    }

    /**
     * @param string $from
     * @param string $to
     * @param bool $undirected
     * @return mixed
     */
    public function addTransition($from, $to, $undirected = false)
    {
        $from = $this->getVertex($from);
        $to = $this->getVertex($to);

        if ($undirected)
            return $from->createEdge($to);

        return $from->createEdgeTo($to);
    }

    /**
     * Set the machine instance to the state
     *
     * @param Machine $machine
     * @return mixed
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;
    }

    /**
     * Get the initial state
     *
     * @param null $override
     * @return mixed
     */
    public function getInitialState($override = null)
    {
        return $this->getState($override ? : $this->initial);
    }
}