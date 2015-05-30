Feature:The setup state should not allow transition to ready until preconditions are met

  Scenario: Setup state should have an edge to ready
    Given I have a "Examples/WhenReadyHandler/FSM" instance
    And Possible transitions should be
      | ready |
    When I transition to ready
    And The state should be setup

  Scenario Outline: It should not transition to ready until all required handlers are run
    Given I have a "Examples/WhenReadyHandler/FSM" instance
    When I run handle <first_handler>
    And I run handle <second_handler>
    And I run handle <third_handler>
    And The state should be <expected_state>
  Examples:
    | first_handler   | second_handler | third_handler  | expected_state |
    | haveCoffee      | releasePigeons | readyUpLlamas  | ready          |
    | readyUpLlamas   | haveCoffee     | releasePigeons | ready          |
    | releasePigeons  | releasePigeons | releasePigeons | setup          |
    | readyUpLlamas   | releasePigeons | releasePigeons | setup          |
    | releasePigeons  | releasePigeons | haveCoffee     | setup          |
    | releasePigeons  | releasePigeons | releasePigeons | setup          |

  Scenario: It should not manually transition to "ready" if pre-conditions are not met
    Given I have a "Examples/WhenReadyHandler/FSM" instance
    When I transition to ready
    Then The state should be setup

