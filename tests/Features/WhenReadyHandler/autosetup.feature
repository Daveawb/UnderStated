Feature:The auto setup state should not allow transition to ready until preconditions are met

  Scenario: It should not transition to ready until all required handlers are run
    Given I have a "Examples/WhenReadyHandler/FSM" instance
    And Initial state is auto_setup
    Then The state should be ready

