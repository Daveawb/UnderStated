<?php namespace FSM\Adapters;

use Fhaculty\Graph\Graph;
use FSM\State;

class GraphStructure implements StructureInterface
{
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
     */
    public function setState($id, State $state)
    {
        $vertex = $this->graph->createVertex($id);

        $vertex->setAttribute('state', $state);

        $state->setVertex($vertex);
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
     * @return mixed
     */
    public function createTransitionTo($from, $to)
    {
        return $this->getVertex($from)
            ->createEdgeTo($this->getVertex($to));
    }
}