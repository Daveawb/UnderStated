<?php namespace UnderStated\Adapters;

use Fhaculty\Graph\Graph;
use UnderStated\Contracts\MachineDriven;
use UnderStated\Contracts\StructureInterface;
use UnderStated\Machine;
use UnderStated\States\State;

class GraphStructure implements StructureInterface, MachineDriven
{
    const VERTEX_ATTRIBUTE = 'state';

    /**
     * @var Machine
     */
    protected $machine;

    /**
     * @var Graph
     */
    protected $graph;

    /**
     * @var null|int
     */
    protected $initial;

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
        if ($this->graph->getVertices()->isEmpty() || $location === 1) {
            $this->initial = $id;
        }

        $vertex = $this->graph->createVertex($id);

        $vertex->setAttribute(self::VERTEX_ATTRIBUTE, $state);

        $state->setVertex($vertex);

        $state->setMachine($this->machine);
    }

    /**
     * @param string $id
     * @return State
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
     * @return bool
     */
    public function canTransitionFrom($from, $to)
    {
        return $this->getVertex($from)
            ->hasEdgeTo($this->getVertex($to));
    }

    /**
     * @param string $state
     * @return string[]
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

        if ($undirected) {
            return $from->createEdge($to);
        }

        return $from->createEdgeTo($to);
    }

    /**
     * Set the machine instance to the state
     *
     * @param Machine $machine
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
