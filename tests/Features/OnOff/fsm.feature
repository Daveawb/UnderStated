Feature:The UnderStated should transition between on off states

  Scenario: It should transition from an initial state
    Given I have a director UnderStated/Examples/OnOffExample/Director instance
    And I run handle flickSwitch
    Then The state should be on
    And I run handle flickSwitch
    Then The state should be off

  Scenario: It should retrieve a list of possible transitions
    Given I have a director UnderStated/Examples/OnOffExample/Director instance
    And I run handle flickSwitch
    And The state should be on
    Then Possible transitions should be
     | off |