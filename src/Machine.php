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
     * The name of the state machine
     *
     * @var string
     */
    protected $name;

    /**
     * The state graph
     *
     * @var Graph
     */
    private $graph;

    /**
     * The laravel application container.
     *
     * @var Container
     */
    private $app;

    /**
     * A collection of state instances.
     *
     * @var Collection
     */
    private $states;

    /**
     * The active state
     *
     * @var State
     */
    private $state;

    /**
     * The initial state
     *
     * @var string
     */
    protected $initial;

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

        $this->events = $app['events'];

        $this->mapStates();
        $this->mapTransitions();

        if ($this->initial)
        {
            $this->initialise($this->initial);
        }
    }

    /**
     * Set the initial state manually
     *
     * @param $state
     */
    public function initialise($state = null)
    {
        if ( ! $state )
        {
            $this->state = $this->states->first();
        }
        else
        {
            $this->state = $this->graph->getVertex($state)
                ->getAttribute('state');
        }

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
     * @param array $args
     * @return bool
     */
    public function transition($state, $args = [])
    {
        $from = $this->state->getVertex();

        $to = $this->graph->getVertex($state);

        if ($from->hasEdgeTo($to))
        {
            if ($this->handle('onExit', $args) !== false)
            {
                $this->state = $to->getAttribute('state');

                if ($this->handle('onEnter', $args) === false)
                {
                    $this->state = $from;
                }

                $this->emit('transition', [$from->getAttribute('state'), $this->state]);
            }
        }
    }

    /**
     * Handle a method on the current state.
     *
     * @param $handle
     * @param array $args
     * @return mixed|void
     */
    public function handle($handle, $args = [])
    {
        if (method_exists($this->state, $handle))
        {
            return call_user_func_array([$this->state, $handle], $args);
        }
    }

    /**
     * Get the current state id.
     *
     * @return string
     */
    public function getCurrentStateId()
    {
        return $this->state->getId();
    }

    /**
     * Get the current state instance
     *
     * @return State
     */
    public function getCurrentState()
    {
        return $this->state;
    }

    /**
     * Get a list of all possible state transitions.
     *
     * @return array
     */
    public function getPossibleTransitions()
    {
        return $this->graph->getVertex($this->getCurrentStateId())
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
     * Get the machines name
     *
     * @return string
     */
    public function getName()
    {
        if (isset($this->name)) return $this->name;

        return $this->name = str_replace('\\', '', strtolower(class_basename($this)));
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

        $vertex = $this->graph->createVertex($instance->getId());

        $instance->setMachine($this);

        $instance->setVertex($vertex);

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

    /**
     * Emit an event
     *
     * @param $type
     * @param array $args
     */
    public function emit($type, $args = [])
    {
        $this->events->fire("{$this->getName()}.{$type}", $args);
    }
}