Feature:The UnderStated should transition to ready using an event

  Scenario: When an event is emitted the state should change
    Given I have a director UnderStated/Examples/EventsExample/Director instance
    Then The state should be init
    When An event check is fired
    Then The state should be ready