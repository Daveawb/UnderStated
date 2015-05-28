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
     * Get an instance of the machines graph
     *
     * @return mixed
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * Map the states to the graph
     */
    private function mapStates()
    {
        foreach($this->states() as $state)
        {
            $instance = $this->getState($state);

            $instance->setMachine($this);

            $this->graph->createVertex($instance->getId())
                ->setAttribute('state', $state);

            $this->states[$state] = $instance;
        }

        $this->state = $this->states->first();

        foreach($this->transitions() as $from => $to)
        {
            $vertex = $this->graph->getVertex($this->states->get($from)->getId());

            $nextVertex = $this->graph->getVertex($this->states->get($to)->getId());

            $vertex->createEdgeTo($nextVertex);
        }
    }

    /**
     * @param string $state
     */
    public function transition($state)
    {
        $from = $this->graph->getVertex($this->state->getId());

        $to = $this->graph->getVertex($state);

//        var_dump($from);
//        var_dump($to);
//        var_dump($from->hasEdgeTo($to));

        if ($from->hasEdgeTo($to))
        {
            $this->handle('onExit');

            $this->state = $this->states->get($to->getAttribute('state'));

            $this->handle('onEnter');
        }
    }

    /**
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
     * @param string $state
     * @return State
     */
    private function getState($state)
    {
        $class = '\\'.ltrim($state, '\\');

        return $this->app->make($class);
    }
}