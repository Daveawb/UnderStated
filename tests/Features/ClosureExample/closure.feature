Feature:The FSM should transition from on to off using closures

  Scenario: It should transition from an initial state
    Given I have a director Examples/ClosureExample/Director instance
    Then The state should be on
    When I transition to off
    Then The state should be off