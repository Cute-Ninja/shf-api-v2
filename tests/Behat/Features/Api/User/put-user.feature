Feature:
  Edit a User

  @api @visitor @userAPI
  Scenario: As an anonymous user I cannot edit as a User
    Given I am an anonymous User
    When I want to modify information using the api "users/ghriim" with the following values
      | username | failure          |
      | email    | failure          |
      | password | failure_password |
    Then access should not be authorized

  @api @user @userAPI @regenerateDB
  Scenario: As a logged user I can modify my own information
    Given I am logged as Ghriim
    When I want to modify information using the api "users/ghriim" with the following values
      | username | success             |
      | email    | ghriim@fakemail.com |
    Then a proper response should be returned

  @api @user @userAPI
  Scenario: As a logged user I cannot modify the information of another existing user
    Given I am logged as Ghriim
    When I want to modify information using the api "users/user_1" with the following values
      | username | success |
    Then access should be forbidden

  @api @administrator @userAPI @regenerateDB
  Scenario: As a logged administrator I can modify any user information
    Given I am logged as an Administrator
    When I want to modify information using the api "users/ghriim" with the following values
      | username | success             |
      | email    | ghriim@fakemail.com |
    Then a proper response should be returned

  @api @administrator @userAPI
  Scenario: As a logged administrator I cannot modify the information of a non existing user
    Given I am logged as an Administrator
    When I want to modify information using the api "users/not_existing" with the following values
      | username | failure              |
      | email    | failure@fakemail.com |
    Then no result should be found
