Feature: The state machine should set states

  Scenario:I want to set an initial state and transition to the next state
    Given I add states
      | uninitialised |
      | initialised |
      | finish |
    And I add transitions
      | uninitialised | initialised |
      | initialised | finish |
    And The initial state is "uninitialised"
    Then The current state is "uninitialised"
    When I transition to "initialised"
    Then The previous state is "uninitialised"
    And The current state is "initialised"
