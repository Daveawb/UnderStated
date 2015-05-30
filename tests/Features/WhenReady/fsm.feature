Feature:The FSM should transition between on off states

  Scenario: It should transition from an initial state
    Given I have a "Examples/WhenReady/FSM" instance
    Then The state should be "first"
    And Possible transitions should be
    | second | third | ready |
    When I transition to "second"
    Then The state should be "second"
    When I transition to "third"
    And The state should be "ready"