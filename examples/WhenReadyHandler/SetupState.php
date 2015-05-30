<?php namespace Examples\WhenReadyHandler;

use FSM\State;

/**
 * Class SetupState
 * @package Examples\WhenReadyHandler
 */
class SetupState extends State {

    /**
     * An array of constraints preventing
     * transition away from this state.
     *
     * @var array
     */
    protected $constraints = [
        'coffee' => false,
        'llamas' => false,
        'pigeons' => false
    ];

    /**
     * haveCoffee handler. Enjoy a nice cup of coffee
     * before you can do anything else.
     */
    public function haveCoffee()
    {
        $this->constraints['coffee'] = true;

        $this->checkReady();
    }

    /**
     * Everyone needs their Llamas ready before they
     * can do anything. Recommended that you have
     * coffee before handling this task.
     */
    public function readyUpLlamas()
    {
        $this->constraints['llamas'] = true;

        $this->checkReady();
    }

    /**
     * Without your homing pigeons you'd be lost.
     * Lets make sure they're released.
     */
    public function releasePigeons()
    {
        $this->constraints['pigeons'] = true;

        $this->checkReady();
    }

    /**
     * To check if we're ready we just need to transition
     * away from this state. If we're not ready the onExit
     * handle will return false and prevent us transitioning.
     */
    protected function checkReady()
    {
        $this->transition('ready');
    }

    /**
     * If our constraints are not satisfied return false and
     * prevent transitioning away from this state.
     *
     * @return bool
     */
    public function onExit()
    {
        return count(array_keys($this->constraints, true)) === count($this->constraints);
    }
}