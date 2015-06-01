Feature:The UnderStated should transition from on to off using closures

  Scenario: It should transition between on and off
    Given I have a director UnderStated/Examples/ClosureExample/Director instance
    Then The state should be off
    When I transition to on
    Then The state should be on
    When I transition to off
    Then The state should be off

  Scenario: It should transition from an initial state
    Given I have a director UnderStated/Examples/ClosureExample/Director instance
    And I run handle flickSwitch
    Then The state should be on
    And I run handle flickSwitch
    Then The state should be off
