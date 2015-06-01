Feature:The auto setup state should not allow transition to ready until preconditions are met

  Scenario: It should not transition to ready until all required handlers are run
    Given I have a director UnderStated/Examples/AutoStateExample/Director instance
    And Initial state is auto_setup
    Then The state should be ready

  Scenario: It should accept an initialise event
    Given I have a director UnderStated/Examples/AutoStateExample/Director instance
    When An external event machine.initialise is fired
    Then The state should be ready

