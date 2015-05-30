<?php namespace Examples\WhenReadyHandler;

use FSM\Machine;

class FSM extends Machine
{
    /**
     * The initial state
     *
     * @var string
     */
    protected $initial = 'setup';

    /**
     * @return array
     */
    public function states()
    {
        return [
            AutoSetupState::class,
            SetupState::class,
            ReadyState::class
        ];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [
            SetupState::class => ReadyState::class,
            AutoSetupState::class => ReadyState::class
        ];
    }
}