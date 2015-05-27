<?php

namespace Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Fhaculty\Graph\Graph;
use FSM\Machine\Builder;
use FSM\Machine\Machine;

/**
 * Defines application features from the specific context.
 */
class FsmContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->builder = new Builder(
            new Machine(
                new Graph()
            )
        );
    }

    /**
     * @Given /^I add states$/
     */
    public function iAddStates(TableNode $table)
    {
        foreach($table->getRows() as $row)
        {
            $this->builder->addState($row[0]);
        }
    }

    /**
     * @Given /^I add transitions$/
     */
    public function iAddTransitions(TableNode $table)
    {
        foreach($table->getRows() as $row)
        {
            $this->builder->addTransition($row[0], $row[1]);
        }
    }

    /**
     * @Given /^The initial state is "([^"]*)"$/
     */
    public function theInitialStateIs($state)
    {
        $this->builder->addInitialState($state);
    }

    /**
     * @When /^I transition to "([^"]*)"$/
     */
    public function iTransitionTo($state)
    {
        $this->machine = $this->builder->getMachine();

        $this->machine->transition($state);
    }

    /**
     * @Then /^The previous state is "([^"]*)"$/
     */
    public function thePreviousStateIs($state)
    {
        $previous = $this->machine->previousState();

        if ( $previous !== $state )
        {
            throw new \Exception("{$state} does not match {$previous}");
        }
    }

    /**
     * @Given /^The current state is "([^"]*)"$/
     */
    public function theCurrentStateIs($state)
    {
        $current = $this->builder->getMachine()->currentState();

        if ( $current !== $state )
        {
            throw new \Exception("{$state} does not match {$current}");
        }
    }

}
