A PHP Finite State Machine (With Laravel 5.4 integration)
==========================
[![Build Status](https://travis-ci.org/Daveawb/UnderStated.svg?branch=master)](https://travis-ci.org/Daveawb/UnderStated)

## Why use an FSM?
FSM's allow developers tight control over the state of different resources within an application. There are many
articles detailing FSM's and what they are and what they're capable of so I won't go into much detail here. Safe to say, by managing state within an FSM you centralise and manage state simply and cleanly without needing to build it into your business logic. There are plenty of examples within this repository that should give you an idea of the practical uses of an FSM. Some good examples are present in libraries such as Redux, Angular UI Router and Apollo. Whilst this is an implementation for PHP where state isn't as much of a problem as other languages or technologies (Browser based JS and more importantly NodeJS) a well constructed FSM can ease the burden of building and rationalising large scale applications.

## Requirements
- \>= PHP 7.0
- (optional) \>= Laravel 5.4

## Installation
### Composer
Add the following to your composer.json file

````json
{
    "require": {
        "daveawb/understated": "0.0.4"
    }
}
````

### Laravel Integration
Open `config/app.php` and register the required service provider.

```php
'providers' => [
    // ...
    UnderStated\Providers\UnderStatedServiceProvider::class,
]
```

## A Simple FSM
````php
use UnderStated\States\State;

$builder = new UnderStated\Builders\GraphBuilder();

$fsm = $builder->create()

    // Create an 'on' state
    ->state('on', function() { /* state is on */ })

    // Create an 'off' state
    ->state('off', function() { /* state is off */ }, State::INITIAL)

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

## Class based FSM
Closures are useful for quick implementations but when complex behaviour is required within states and in the transition logic, it is much better to create state representations as classes. We'll look again at the on off example.

For full examples using states and implementing complex interactions please review the example implementations included in this project.

Each state has three predefined handles that are called automatically by the FSM. These are `onEnter()`, `onExit()` and `onReset()`.

### onEnter()
```php
/**
 * Automatically called when this state is transitioned to. Returning false from
 * this method will block the transition attempt and the previous state will
 * remain as the active state.
 *
 * @param  State $previousState
 * @return boolean
 */
public function onEnter(State $previousState)
```
Calling `transition()` or `handle()` on the previous state however will throw an exception and will not fulfil either method.

### onExit()
```php
/**
 * Automatically called when this state is transitioned from. Returning false from
 * this method will block the transition attempt and the current state will
 * remain as the active state.
 *
 * @param  State $nextState
 * @return boolean
 */
public function onExit(State $nextState)
```
This method, much like onEnter, is fired when transitioning from the current state to another. The same rules apply as per onEnter, calling `transition()` or `handle()` on the next state will throw an exception.

### onReset()
This method is used for cleaning up the state once it has been transitioned from and is no longer active. This method is used internally for removing event bindings from the state and as such if you override this method be sure to call the parents implementation.

````php
public function onReset()
{
    // <-- Clean up logic here

    parent::onReset();
}
````
### Example state
````php
use UnderStated\State;

class StateOne extends State
{
    /**
     * @param State
     * @return bool
     */
    public function onEnter(State $previous)
    {
        $this->handle('myHandle');

        return true;
    }

    /**
     * A state handler
     */
    public function myHandle()
    {
        // I'm handled when the state changes
    }

    /**
     * @param State
     * @return boolean
     */
    public function onExit(State $next)
    {
        // Will return true if unimplemented
        return true;
    }
}
````

Using this state is a case of giving the fully qualified class name as the second parameter to the builders state method.

````php
$builder->create()
    ->state('on', StateOne::class)
````

# Examples
Take a look at the [examples](https://github.com/Daveawb/UnderStated/tree/master/examples) for a comprehensive select
 of different ways the FSM can be used.

# Changelog
0.0.4 -> 1.0.0
- General code tidy up, PSR-2 compliance and removed some unused code.
- Deprecated and removed `get` method from the `MachineBuilder` interface in favour of `getMachine`.
- `getMachine` method accepts no arguments and can not initialise an FSM unlike its precursor `get`.
- `transition` method on `Machine` now returns a boolean to indicate success.
