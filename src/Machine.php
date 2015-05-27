<?php namespace FSM;

use FSM\Contracts\Machine\MachineInterface;
use FSM\Contracts\ComponentInterface;
use FSM\Contracts\StateInterface;
use FSM\Contracts\StructureInterface;

/**
 * Class Machine
 * @package FSM
 */
class Machine implements MachineInterface
{
    /**
     * @var StructureInterface
     */
    protected $structure;

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * Register a structure with the base machine.
     *
     * @param StructureInterface $structure
     * @return mixed
     */
    public function structure(StructureInterface $structure)
    {
        $this->structure = $structure;

        $this->registerComponent($structure);
    }

    /**
     * Register a state with the base machine.
     *
     * @param StateInterface $state
     * @param bool $initial
     * @return mixed
     */
    public function state(StateInterface $state, $initial = false)
    {
        $this->registerComponent($state);

        $this->structure->addState($state, $initial);
    }

    /**
     * Register this machine as a mediator.
     *
     * @param $component
     */
    protected function registerComponent(ComponentInterface $component)
    {
        $component->FSM($this);
    }

    /**
     * @param StateInterface $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}
