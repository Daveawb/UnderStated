<?php namespace FSM;

use FSM\Contracts\Machine\Buildable;
use FSM\Contracts\Machine\BuilderInterface;
use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\StateInterface;
use FSM\Contracts\StructureInterface;

/**
 * Class Builder
 * @package FSM\Machine
 */
class Builder implements BuilderInterface
{
    /**
     * @var StructureInterface
     */
    private $structure;
    /**
     * @var MachineInterface
     */
    private $machine;

    /**
     * @param MachineInterface $machine
     * @param StructureInterface $structure
     */
    public function __construct(MachineInterface $machine, StructureInterface $structure)
    {
        $this->structure = $structure;
        $this->machine = $machine;

        $this->machine->structure($this->structure);
    }

    /**
     * Add a new state
     *
     * @param StateInterface $state
     * @param bool $initial
     * @return $this
     */
    public function addState(StateInterface $state, $initial = false)
    {
        $this->machine->state($state, $initial);
    }

    /**
     * Add a transition from one state to another
     *
     * @param string $from
     * @param string $to
     * @param bool $reverse
     * @return $this
     */
    public function addTransition($from, $to, $reverse = false)
    {
        // TODO: Implement addTransition() method.
    }

    /**
     * Get the state machine instance
     *
     * @return Buildable
     */
    public function getMachine()
    {
        // TODO: Implement getMachine() method.
    }
}
