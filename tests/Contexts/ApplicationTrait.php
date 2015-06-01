<?php namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use FSM\Builders\GraphBuilder;
use FSM\Machine;
use Illuminate\Container\Container;

trait ApplicationTrait {

    /**
     * @var Machine
     */
    protected $fsm;

    /**
     * @var Container
     */
    protected static $app;

    /**
     * @beforeSuite
     */
    public static function setUpSuite()
    {
        static::$app = require(__DIR__ . '/bootstrap.php');
    }

    /**
     * @Given /^I have a director (.*) instance$/
     */
    public function iHaveADirectorInstance($director)
    {
        $director = $this->createInstance($director);

        $this->fsm = $director->build(static::$app->make(GraphBuilder::class));
    }

    /**
     * @Given /^I run handle (.*)$/
     */
    public function iRunHandle($handle)
    {
        $this->fsm->handle($handle);
    }

    /**
     * @Then /^The state should be (.*)$/
     */
    public function theStateShouldBe($state)
    {
        $fsmState = $this->fsm->getState()->getId();

        if ($fsmState !== $state)
        {
            throw new \Exception("FSM state is {$fsmState}. Not {$state}.");
        }
    }

    /**
     * @Then /^Possible transitions should be$/
     */
    public function possibleTransitionsShouldBe(TableNode $table)
    {
        $states = $table->getRow(0);

        $transitions = $this->fsm->getTransitions();

        foreach ($states as $state)
        {
            if ( ! in_array($state, $transitions) )
            {
                throw new \Exception("{$state} was not in the possible transitions list.");
            }
        }
    }

    /**
     * @When /^I transition to (.*)$/
     */
    public function iTransitionTo($transition)
    {
        $this->fsm->transition($transition);
    }

    /**
     * @Given /^Initial state is (.*)$/
     */
    public function initialStateIs($initial_state)
    {
        $this->fsm->initialise($initial_state);
    }

    /**
     * @param $class
     * @return mixed
     */
    private function createInstance($class)
    {
        $prepared = '\\'.ltrim(str_replace('/', '\\', $class), '\\');

        return static::$app->make($prepared);
    }
}