<?php namespace FSM;

use Closure;
use FSM\Contracts\EventInterface;
use FSM\Contracts\StructureInterface;
use FSM\States\ClosureState;

/**
 * Class Machine
 * @package FSM
 */
class Machine
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
     * List of historical transitions
     *
     * @var array
     */
    private $history = [];

    /**
     * The active state
     *
     * @var State
     */
    private $state;

    /**
     * Construct the machine
     *
     * @param EventInterface $events
     */
    public function __construct(EventInterface $events)
    {
        $this->events = $events;
    }

    /**
     * Set the initial state manually
     *
     * @param null $state
     */
    public function initialise($state = null)
    {
        $this->state = $this->structure->getInitialState($state);

        $this->handle('onEnter');
    }

    /**
     * Transition from the current state to another via a valid
     * edge on the graph.
     *
     * @param string $state
     * @param array $args
     *
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
                        $this->state
                    ]);

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
     *
     * @return mixed|void
     */
    public function handle($handle, $args = [], $result = true)
    {
        array_unshift($args, $this->state);

        $result = call_user_func_array([$this->state, $handle], $args);

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
     * @param StructureInterface $structure
     */
    public function setStructure(StructureInterface $structure)
    {
        $this->structure = $structure;
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