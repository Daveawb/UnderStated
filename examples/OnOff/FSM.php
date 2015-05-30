<?php namespace Examples\OnOff;

use FSM\Machine;

class FSM extends Machine
{
    /**
     * @return array
     */
    public function states()
    {
        return [
            OffState::class,
            OnState::class
        ];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [
            OnState::class => OffState::class,
            OffState::class => OnState::class
        ];
    }
}