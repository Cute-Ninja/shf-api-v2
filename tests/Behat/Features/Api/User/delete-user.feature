Feature:
  Delete an User

  @api @visitor @userAPI
  Scenario: As an anonymous user I cannot delete an User
    Given I am an anonymous User
    When I want to delete information using the api "users/ghriim"
    Then access should not be authorized

  @api @user @userAPI
  Scenario: As a logged user I cannot delete my User
    Given I am logged as Ghriim
    When I want to delete information using the api "users/ghriim"
    Then access should be forbidden

  @api @administrator @userAPI @regenerateDB
  Scenario: As a logged administrator I cannot register as a new User
    Given I am logged as an Administrator
    When I want to delete information using the api "users/ghriim"
    Then a proper response should be returned
