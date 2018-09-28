Feature:
  Complete a UserMission

  @api @visitor @userMission
  Scenario: As an anonymous User I cannot complete a UserMission
    Given I am an anonymous User
    When I want to do the action "complete" using the api "user-missions" with the following values
      | missionId | 1 |
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged User I cannot complete a non existing UserMission
    Given I am logged as Ghriim
    When I want to do the action "complete" using the api "user-missions" with the following values
      | missionId | 0 |
    Then no result should be found

  @api @user @regenerateDB @userMission
  Scenario: As a logged User I can complete a UserMission
    Given I am logged as Ghriim
    When I want to do the action "complete" using the api "user-missions" with the following values
      | missionId | 1 |
    Then a proper response should be returned

  @api @administrator @userMission
  Scenario: As a logged Administrator I cannot complete a non existing UserMission
    Given I am logged as Ghriim
    When I want to do the action "complete" using the api "user-missions" with the following values
      | missionId | 0 |
    Then no result should be found

  @api @administrator @regenerateDB @userMission
  Scenario: As a logged Administrator I can complete a UserMission
    Given I am logged as an Administrator
    When I want to do the action "complete" using the api "user-missions" with the following values
      | missionId | 1 |
    Then a proper response should be returned
