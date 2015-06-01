<?php namespace UnderStated\Examples\ConstraintExample;

use UnderStated\States\State;

class SecondState extends State {

    /**
     * @param State $state
     * @return bool|void
     */
    public function onEnter(State $state)
    {
        $this->machine->unGuard('second');

        if ($this->machine->checkReady())
        {
            $this->transition('ready');
        }
    }
}