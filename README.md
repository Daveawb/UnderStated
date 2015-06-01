A Finite State Machine for Laravel
==================================

#Why use an FSM?
FSM's are a resource that allow developers tight control over resources within an application. There are many 
articles detailing FSM's and what they are and what they're capable of so I won't go into much detail here.

#Requirements
- >= PHP 5.5
- >= Laravel 5.*

#Installation
##Composer
Add the following to your composer.json file

````json
{
    "require": {
        "daveawb/understated": "0.0.1"
    },
}
````

#A Simple FSM
````php
use UnderStated\States\State;

$builder = new UnderStated\Builders\GraphBuilder();

$fsm = $builder->create()

    // Create a state state(string $id, array||classname||closure $resolve, int $location)
    ->state('on', function() { // state is on })
    
    // Create another state
    ->state('off', function() { // state is off }), State::INITIAL)
    
    // Create a transition (undirected) between the two states
    ->transition('on', 'off', true)
    
    // Get the FSM instance
    ->get();
````

Now that we have that out of the way, how do you use it?

We declared an undirected transition between states 'on' and 'off'. This means that both those states are capable of 
transitioning from one to the other indefinitely. Also notice the `State::INITIAL` passed as the third argument to 
the 'off' state. This will mean that when the FSM is initialised this will be the state it is in.

Before we go any further we need to initialise the FSM.

````php
// Initialise using the state marked with State::INITIAL or the first state added.
$fsm->initialise();

// If you want to override the initial state, pass it in to the `initialise` method
$fsm->initialise('on');
````

Now the FSM is initialised we can start transitioning from one state to another.

````php
$fsm->transition('on');

echo ($fsm->getState()->getId()); // outputs 'on'

$fsm->transition('off');

echo ($fsm->getState()->getId()); // outputs 'off'
````

#Examples
Take a look at the [examples](https://github.com/Daveawb/UnderStated/tree/master/examples) for a comprehensive select
 of different ways the FSM can be used.