<?php namespace Examples\AutoStateExample;

use FSM\States\State;

/**
 * Class AutoSetupState
 * @package Examples\WhenReadyHandler
 */
class AutoSetupState extends State {

    /**
     * An array of constraints preventing transition away
     * from this state. Keyed by the handlers signature.
     *
     * @var array
     */
    protected $constraints = [
        'haveCoffee' => false,
        'readyUpLlamas' => false,
        'releasePigeons' => false
    ];

    /**
     * Start the automatic setup by calling the checkReady
     * method. This will run through all the constraints and
     * run their handlers and finally transitioning to ready.
     *
     * @return bool
     */
    public function onEnter()
    {
        $this->checkReady();
    }

    /**
     * Enjoy a nice cup of coffee before you
     * do anything else.
     */
    public function haveCoffee()
    {
        $this->constraints['haveCoffee'] = true;

        $this->checkReady();
    }

    /**
     * Everyone needs their Llamas readied up.
     */
    public function readyUpLlamas()
    {
        $this->constraints['readyUpLlamas'] = true;

        $this->checkReady();
    }

    /**
     * Without your homing pigeons you'd be lost.
     * Lets make sure they're released.
     */
    public function releasePigeons()
    {
        $this->constraints['releasePigeons'] = true;

        $this->checkReady();
    }

    /**
     * Check if the state can transition or has to handle more
     * setup methods before a transition can occur.
     */
    protected function checkReady()
    {
        $next = array_keys($this->constraints, false);

        if (count($next) > 0)
        {
            $this->handle($next[0], []);
        }
        else
        {
            $this->transition('ready');
        }
    }

    /**
     * Stop accidental transition out of this state without pre-conditions
     * having been met.
     *
     * @return bool
     */
    public function onExit()
    {
        return count(array_keys($this->constraints, true)) === count($this->constraints);
    }
}