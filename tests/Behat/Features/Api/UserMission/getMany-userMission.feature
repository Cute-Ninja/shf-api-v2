Feature:
  Get the list of UserMissions

  @api @visitor @userMission
  Scenario: As an anonymous user I cannot access the list of UserMissions
    Given I am an anonymous User
    When I request the api "user-missions"
    Then access should not be authorized

  @api @user @userMission
  Scenario: As a logged user I can access the list of UserMissions
    Given I am logged as Ghriim
    When I request the api "user-missions"
    Then an error should be returned

  @api @administrator @userMission
  Scenario: As a logged administrator I access the list of UserMissions
    Given I am logged as an Administrator
    When I request the api "user-missions"
    Then an error should be returned
