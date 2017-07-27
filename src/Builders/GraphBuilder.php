<?php

namespace UnderStated\Builders;

use Fhaculty\Graph\Graph;
use UnderStated\Adapters\GraphStructure;
use UnderStated\Contracts\MachineBuilder;
use UnderStated\Machine;
use UnderStated\States\StateFactory;

/**
 * Class GraphBuilder
 * @package UnderStated\Builders
 */
class GraphBuilder implements MachineBuilder
{
    /**
     * @var GraphStructure
     */
    protected $graph;

    /**
     * @var Machine
     */
    protected $machine;

    /**
     * @var StateFactory
     */
    private $stateFactory;

    /**
     * Construct the builder
     */
    public function __construct()
    {
        $this->graph = new GraphStructure(new Graph);
        $this->stateFactory = new StateFactory();
    }

    /**
     * Create a new graph instance
     *
     * @param Machine $machine
     *
     * @return $this
     */
    public function create(Machine $machine = null)
    {
        $machine = $machine ? : app()->make(Machine::class);

        $this->machine = $machine;

        $this->graph->setMachine($machine);

        return $this;
    }

    /**
     * Add a new state
     *
     * @param $id
     * @param $resolvable
     * @param int $location
     * @return $this
     */
    public function state($id, $resolvable = null, $location = 0)
    {
        $state = $this->stateFactory->create($id, $resolvable);

        $this->graph->addState($id, $state, $location);

        return $this;
    }

    /**
     * Add a list of states
     *
     * @param array $states
     * @return mixed
     */
    public function states(array $states)
    {
        foreach ($states as $state) {
            call_user_func_array([$this, 'state'], $state);
        }

        return $this;
    }

    /**
     * Add a new transition
     *
     * @param $fromId
     * @param $toId
     * @param int $undirected
     * @return $this
     */
    public function transition($fromId, $toId, $undirected = 0)
    {
        $this->graph->addTransition($fromId, $toId, $undirected);

        return $this;
    }

    /**
     * Add a list of transitions
     *
     * @param array $transitions
     * @return mixed
     */
    public function transitions(array $transitions)
    {
        foreach ($transitions as $transition) {
            call_user_func_array([$this, 'transition'], $transition);
        }

        return $this;
    }

    /**
     * Get the built machine
     *
     * @param bool $initialise
     * @return Machine
     */
    public function get($initialise = false)
    {
        $machine = $this->machine ? : $this->create()->machine;

        $machine->setStructure($this->graph);

        if ($initialise) {
            $machine->initialise();
        }

        return $machine;
    }
}
