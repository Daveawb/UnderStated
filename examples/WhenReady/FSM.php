<?php namespace Examples\WhenReady;

use FSM\Machine;

class FSM extends Machine
{
    protected $constraints = [
        'first' => false,
        'second' => false,
        'third' => false
    ];

    /**
     * @return array
     */
    public function states()
    {
        return [
            FirstState::class,
            SecondState::class,
            ThirdState::class,
            ReadyState::class
        ];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [
            FirstState::class => [
                SecondState::class,
                ThirdState::class,
                ReadyState::class
            ],
            SecondState::class => [
                FirstState::class,
                ThirdState::class,
                ReadyState::class
            ],
            ThirdState::class => [
                FirstState::class,
                SecondState::class,
                ReadyState::class,
            ]
        ];
    }

    public function checkReady()
    {
        return count(array_keys($this->constraints, true)) === count($this->constraints);
    }

    public function unGuard($state)
    {
        $this->constraints[$state] = true;
    }
}