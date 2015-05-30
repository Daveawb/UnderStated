<?php namespace Contexts\OnOff;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Contexts\ApplicationTrait;
use Illuminate\Container\Container;

/**
 * Defines application features from the specific context.
 */
class FsmContext implements Context, SnippetAcceptingContext
{
    use ApplicationTrait;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }
}
