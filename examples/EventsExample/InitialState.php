<?php namespace UnderStated\Examples\EventsExample;

use UnderStated\States\State;

/**
 * Class InitialState
 * @package UnderStated\Examples\EventsExample
 */
class InitialState extends State
{
    /**
     * Return void or true to maintain this state
     * and not revert to previous state.
     *
     * @param State $state
     * @return void
     */
    public function onEnter(State $state)
    {
        // Bind an event listener to the machine. During this states
        // active lifecycle this event will be listened for. To trigger
        // you can call $fsm->fire('ready'). From external you can use
        // Laravels event system: `Event::fire('machine.check', [$fsm])`
        $this->listen('check' , function($fsm)
        {
            $fsm->transition('ready');
        });
    }
}
