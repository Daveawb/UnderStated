<?php namespace FSM;

use Fhaculty\Graph\Graph;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class Machine
 * @package FSM
 */
abstract class Machine
{
    /**
     * @var
     */
    private $graph;

    /**
     * @var Container
     */
    private $app;

    /**
     * @var Collection
     */
    private $states;

    /**
     * Construct the machine
     *
     * @param Container $app
     * @param Graph $graph
     * @param Collection $states
     */
    public function __construct(Container $app, Graph $graph, Collection $states)
    {
        $this->app = $app;
        $this->graph = $graph;
        $this->states = $states;

        $this->mapStates();
        $this->mapTransitions();

        $this->state = $this->states->first();

        $this->handle('onEnter');
    }

    /**
     * Return a class list of all the states
     *
     * @return array
     */
    abstract public function states();

    /**
     * Return an array of transitions state => state
     *
     * @return array
     */
    abstract public function transitions();

    /**
     * Map the states to the graph
     *
     * @return void
     */
    private function mapStates()
    {
        foreach ($this->states() as $state)
        {
            $this->createStateVertex($state);
        }
    }

    /**
     * Map the transitions from state to state
     *
     * @return void
     */
    private function mapTransitions()
    {
        foreach ($this->transitions() as $from => $to)
        {
            if (is_array($to))
            {
                foreach ($to as $shard)
                {
                    $this->createStateTransition($from, $shard);
                }
            }
            else
            {
                $this->createStateTransition($from, $to);
            }
        }
    }

    /**
     * Transition from the current state to another via a valid
     * edge on the graph.
     *
     * @param string $state
     *
     * @return bool
     */
    public function transition($state)
    {
        $from = $this->graph->getVertex($this->getCurrentState());

        $to = $this->graph->getVertex($state);

        if ($from->hasEdgeTo($to))
        {
            $this->handle('onExit');

            $this->state = $to->getAttribute('state');

            $this->handle('onEnter');
        }
    }

    /**
     * Handle a method on the current state.
     *
     * @param $handle
     * @param array $args
     * @return mixed
     */
    public function handle($handle, $args = [])
    {
        if (method_exists($this->state, $handle))
        {
            call_user_func_array([$this->state, $handle], $args);
        }
    }

    /**
     * Get the current state name.
     *
     * @return string
     */
    public function getCurrentState()
    {
        return $this->state->getId();
    }

    /**
     * Get a list of all possible state transitions.
     *
     * @return array
     */
    public function getPossibleTransitions()
    {
        return $this->graph->getVertex($this->getCurrentState())
            ->getVerticesEdgeTo()
            ->getIds();
    }

    /**
     * Get the machines graph instance.
     *
     * @return mixed
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * Create a new state instance from a FQC
     *
     * @param string $state
     * @return State
     */
    private function createNewState($state)
    {
        $class = '\\' . ltrim($state, '\\');

        return $this->app->make($class);
    }

    /**
     * Create a new vertex on the graph for a state
     *
     * @param $state
     *
     * @return \Fhaculty\Graph\Vertex
     */
    private function createStateVertex($state)
    {
        $instance = $this->createNewState($state);

        $instance->setMachine($this);

        $vertex = $this->graph->createVertex($instance->getId());

        $vertex->setAttribute('state', $instance);

        $this->states[$state] = $instance;

        return $vertex;
    }

    /**
     * Create a new directed edge from one state to another
     *
     * @param $from
     * @param $to
     *
     * @return \Fhaculty\Graph\Edge\Directed
     */
    private function createStateTransition($from, $to)
    {
        $vertex = $this->graph->getVertex($this->states->get($from)->getId());

        return $vertex->createEdgeTo($this->graph->getVertex($this->states->get($to)->getId()));
    }
}