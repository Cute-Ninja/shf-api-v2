Feature:
  Get the details of a given UserMission

  @api @visitor @userMission
  Scenario: As an anonymous user I cannot access the details of a UserMission
    Given I am an anonymous User
    When I request the api "user-missions/1"
    Then access should not be authorized

  @api @visitor @userMission
  Scenario: As an anonymous user I cannot access the details of a non existing UserMission
    Given I am an anonymous User
    When I request the api "user-missions/0"
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged user I can access the details of a UserMission
    Given I am logged as Ghriim
    When I request the api "user-missions/1"
    Then an error should be returned

  @api @user @userMission
  Scenario: As a logged user I cannot access the details of a non existing UserMission
    Given I am logged as Ghriim
    When I request the api "user-missions/0"
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I can access the details of a UserMission
    Given I am logged as an Administrator
    When I request the api "user-missions/1"
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I cannot access the details of a non existing UserMission
    Given I am logged as an Administrator
    When I request the api "user-missions/0"
    Then an error should be returned
