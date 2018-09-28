Feature:
  Edit a UserMission

  @api @visitor @userMission
  Scenario: As an anonymous User I cannot modify a UserMission
    Given I am an anonymous User
    When I want to modify information using the api "user-missions/1" with the following values
      | | |
    Then access should not be authorized

  @api @visitor @userMission
  Scenario: As an anonymous User I cannot modify a non existing UserMission
    Given I am an anonymous User
    When I want to modify information using the api "user-missions/0" with the following values
      | | |
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged User I cannot modify a a non existing UserMission
    Given I am logged as Ghriim
    When I want to modify information using the api "user-missions/0" with the following values
      | | |
    Then an error should be returned

  @api @user @userMission
  Scenario: As a logged User I cannot modify a UserMission if my information are incorrect
    Given I am logged as Ghriim
    When I want to modify information using the api "user-missions/1" with the following values
      | | |
    Then an error should be returned

  @api @user @userMission
  Scenario: As a logged User I can modify a UserMission if my information are correct
    Given I am logged as Ghriim
    When I want to modify information using the api "user-missions/1" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I cannot modify a non existing UserMission
    Given I am logged as an Administrator
    When I want to modify information using the api "user-missions/0" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I cannot modify a UserMission if my information are incorrect
    Given I am logged as an Administrator
    When I want to modify information using the api "user-missions/1" with the following values
      | | |
    Then an error should be returned

  @api @administrator  @userMission
  Scenario: As a logged administrator I can modify a UserMission if my information are correct
    Given I am logged as an Administrator
    When I want to modify information using the api "user-missions/1" with the following values
      | | |
    Then an error should be returned
