Feature:The FSM should transition to ready using an event

  Scenario: When an event is emmited the state should change
    Given I have a director Examples/EventsExample/Director instance
    Then The state should be init
    When An event check is emitted
    Then The state should be ready