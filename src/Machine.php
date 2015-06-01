<?php namespace FSM;

use Closure;
use FSM\Contracts\EventInterface;
use FSM\Contracts\StructureInterface;
use FSM\Exceptions\UninitialisedException;
use FSM\States\State;

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
    protected $id;

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
     * @return bool
     * @throws UninitialisedException
     */
    public function transition($state)
    {
        if ( ! $this->state )
            throw new UninitialisedException('FSM is not initialised.');

        if ($this->structure->canTransitionFrom($id = $this->getState()->getId(), $state))
        {
            if ( $this->execHandle('onExit', [$next = $this->structure->getState($state)]) )
            {
                array_push($this->history, $id);

                $this->setState($next);

                if ( $this->execHandle('onEnter', [$from = $this->structure->getState($id)]) )
                {
                    // Remove all the bound events from the previous state
                    $this->forget($from->getBoundEvents());

                    // Emit a transition event
                    $this->emit('transition', [
                        $from,
                        $this->state
                    ]);
                }
                else
                {
                    $this->setState($this->structure->getState(
                        array_splice($this->history, -1, 1)[0]
                    ));
                }
            }
        }
    }

    /**
     * Handle a method on the current state.
     *
     * @param $handle
     * @param array $args
     *
     * @return mixed|void
     *
     * @throws UninitialisedException
     */
    public function handle($handle, $args = [])
    {
        if ( ! $this->state )
            throw new UninitialisedException('FSM is not initialised.');

        array_unshift($args, $this->state);

        $data = $this->execHandle($handle, $args);

        $this->emit("handled.{$handle}", [$this->state, $data]);

        return $data;
    }

    /**
     * Execute the handler on the state
     *
     * @param $handle
     * @param array $args
     *
     * @return mixed
     */
    protected function execHandle($handle, $args = [])
    {
        $result = call_user_func_array([$this->state, $handle], $args);

        return is_null($result) ? : $result;
    }

    /**
     * Get the history array
     *
     * @return array
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Get a list of all possible state transitions.
     *
     * @return array
     */
    public function getTransitions()
    {
        return $this->structure->getTransitionsFrom($this->getState()->getId());
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
     * Set the current state
     *
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
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
     * @param StructureInterface $structure
     */
    public function setStructure(StructureInterface $structure)
    {
        $this->structure = $structure;
    }

    /**
     * Get the machines id
     *
     * @return string
     */
    public function getId()
    {
        if (isset($this->id)) return $this->id;

        return $this->id = str_replace('\\', '', strtolower(class_basename($this)));
    }

    /**
     * Set the machines id
     *
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Emit an event
     *
     * @param $type
     * @param array $args
     */
    public function emit($type, $args = [])
    {
        array_unshift($args, $this);

        $this->events->emit("{$this->getId()}.{$type}", $args);
    }

    /**
     * @param $type
     * @param callable $closure
     */
    public function listen($type, Closure $closure)
    {
        $this->events->listen("{$this->getId()}.{$type}", $closure);
    }

    /**
     * @param $events
     */
    public function forget($events)
    {
        $this->events->forget($events);
    }
}
