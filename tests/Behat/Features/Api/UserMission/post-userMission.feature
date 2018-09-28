Feature:
  Add a new UserMission

  @api @visitor @userMission
  Scenario: As an anonymous User I cannot add a new UserMission
    Given I am an anonymous User
    When I want to add information using the api "user-missions" with the following values
      | | |
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged User I cannot add a new UserMission if my information are incorrect
    Given I am logged as Ghriim
    When I want to add information using the api "user-missions" with the following values
      | | |
    Then an error should be returned

  @api @user @userMission
  Scenario: As a logged User I can add a new UserMission if my information are correct
    Given I am logged as Ghriim
    When I want to add information using the api "user-missions" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I cannot add a new UserMission if my information are incorrect
    Given I am logged as an Administrator
    When I want to add information using the api "user-missions" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I can add a new UserMission if my information are correct
    Given I am logged as an Administrator
    When I want to add information using the api "user-missions" with the following values
      | | |
    Then an error should be returned
