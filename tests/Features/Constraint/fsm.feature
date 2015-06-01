Feature:The UnderStated should not transition to ready until preconditions are met

  Scenario: States should have edges to other states
    Given I have a director UnderStated/Examples/ConstraintExample/Director instance
    Then Initial state is first
    And Possible transitions should be
      | second | third | ready |
    When I transition to second
    Then Possible transitions should be
      | first | third | ready |
    When I transition to third
    And The state should be ready

  Scenario Outline: It should not transition to ready until all required states are visited
    Given I have a director UnderStated/Examples/ConstraintExample/Director instance
    And Initial state is <initial_state>
    When I transition to <second_state>
    Then The state should be <second_state>
    When I transition to <third_state>
    And The state should be <expected_state>
  Examples:
    | initial_state | second_state | third_state | expected_state |
    | first         | second       | third       | ready          |
    | second        | third        | second      | second         |
    | third         | first        | third       | third          |
    | second        | third        | first       | ready          |
    | second        | first        | third       | ready          |
    | first         | second       | first       | first          |

  Scenario Outline: It should not manually transition to "ready" if pre-conditions are not met
    Given I have a director UnderStated/Examples/ConstraintExample/Director instance
    And Initial state is <state>
    When I transition to ready
    Then The state should be <state>
  Examples:
    | state   |
    | first   |
    | second  |
    | third   |