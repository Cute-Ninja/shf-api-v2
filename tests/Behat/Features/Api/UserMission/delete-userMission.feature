Feature:
  Delete an UserMission

  @api @visitor @userMission
  Scenario: As an anonymous user I cannot delete a UserMission
    Given I am an anonymous User
    When I want to delete information using the api "user-missions/1"
    Then access should not be authorized

  @api @visitor @userMission
  Scenario: As an anonymous user I cannot delete a non existing UserMission
    Given I am an anonymous User
    When I want to delete information using the api "user-missions/0"
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged user I cannot delete a non existing UserMission
    Given I am logged as Ghriim
    When I want to delete information using the api "user-missions/0"
    Then an error should be returned

  @api @user @userMission
  Scenario: As a logged user I cannot delete a UserMission
    Given I am logged as Ghriim
    When I want to delete information using the api "user-missions/1"
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I cannot delete a non existing UserMission
    Given I am logged as an Administrator
    When I want to delete information using the api "user-missions/0"
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I can delete a UserMission
    Given I am logged as an Administrator
    When I want to delete information using the api "user-missions/1"
    Then an error should be returned
