<?php namespace FSM;

use Closure;
use FSM\Adapters\EventInterface;
use FSM\Adapters\StructureInterface;
use Illuminate\Container\Container;

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
     * The state structure
     *
     * @var StructureInterface
     */
    private $structure;

    /**
     * The laravel application container.
     *
     * @var Container
     */
    private $app;

    /**
     * List of historical transitions
     *
     * @var array
     */
    private $history = [];

    /**
     * A map of state ids => class names.
     *
     * @var array
     */
    private $states = [];

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
     * @param StructureInterface $structure
     * @param EventInterface $events
     */
    public function __construct(
        Container $app,
        StructureInterface $structure,
        EventInterface $events
    )
    {
        $this->app = $app;
        $this->structure = $structure;
        $this->events = $events;

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
        if (count($this->states) <= 0 )
        {
            $this->mapStates();
            $this->mapTransitions();
        }

        if ( ! $state )
        {
            reset($this->states);

            $this->state = key($this->states);
        }
        else
        {
            $this->state = $this->structure->getState($state);
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
     * Map the states to the structure
     *
     * @return void
     */
    private function mapStates()
    {
        foreach ($this->states() as $state)
        {
            $this->createState($state);
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
                    $this->createTransition($from, $shard);
                }
            }
            else
            {
                $this->createTransition($from, $to);
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
        if ($this->structure->canTransitionFrom($id = $this->getStateId(), $state))
        {
            if ( $this->handle('onExit', $args) )
            {
                array_push($this->history, $id);

                $this->state = $this->structure->getState($state);

                if ( $this->handle('onEnter', $args) )
                {
                    $this->emit('transition', [
                        $this->structure->getState(last($this->history)),
                        $this->state]
                    );

                    reset($this->history);
                }
                else
                {
                    $this->state = $this->structure->getState(
                        array_splice($this->history, -1, 1)[0]
                    );
                }
            }
        }
    }

    /**
     * Handle a method on the current state.
     *
     * @param $handle
     * @param array $args
     * @param bool $result
     * @return mixed|void
     */
    public function handle($handle, $args = [], $result = true)
    {
        if (method_exists($this->state, $handle))
        {
            $result = call_user_func_array([$this->state, $handle], $args);
        }

        return is_bool($result) ? $result : true;
    }

    /**
     * Get the current state id.
     *
     * @return string
     */
    public function getStateId()
    {
        return $this->state->getId();
    }

    /**
     * Get the current state instance
     *
     * @return State
     */
    public function getState()
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
        return $this->structure->getTransitionsFrom($this->getStateId());
    }

    /**
     * Get the machines structure instance.
     *
     * @return mixed
     */
    public function getStructure()
    {
        return $this->structure;
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
     * Apply the state to the structure
     *
     * @param string $stateClass
     */
    private function createState($stateClass)
    {
        $state = $this->newState($stateClass);

        $state->setMachine($this);

        $this->structure->setState($id = $state->getId(), $state);

        $this->states[$id] = $stateClass;
    }

    /**
     * Create a new state instance from a FQC
     *
     * @param string $stateClass
     * @return State
     */
    private function newState($stateClass)
    {
        $class = '\\' . ltrim($stateClass, '\\');

        return $this->app->make($class);
    }

    /**
     * Create a new directed edge from one state to another
     *
     * @param string $from
     * @param string $to
     *
     * @return \Fhaculty\Graph\Edge\Directed
     */
    private function createTransition($from, $to)
    {
        $from = array_keys($this->states, $from);

        $to = array_keys($this->states, $to);

        return $this->structure->createTransitionTo($from[0], $to[0]);
    }

    /**
     * Emit an event
     *
     * @param $type
     * @param array $args
     */
    public function emit($type, $args = [])
    {
        array_unshift($args, $this, $this->state);

        $this->events->emit("{$this->getName()}.{$type}", $args);
    }

    /**
     * @param $type
     * @param callable $closure
     */
    public function listen($type, Closure $closure)
    {
        $this->events->listen("{$this->getName()}.{$type}", $closure);
    }
}