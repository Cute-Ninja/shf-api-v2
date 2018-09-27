Feature:
  Register a new User

  @api @visitor @user_api
  Scenario: As an anonymous user I cannot register as a new User if my information are incorrect
    Given I am an anonymous User
    When I want to add information using the api "users/registration" with the following values
      | username | failure          |
      | email    | failure          |
      | password | failure_password |
    Then form errors should be returned

  @api @visitor @user_api @regenerateDB
  Scenario: As an anonymous user I can register as a new User if my information are correct
    Given I am an anonymous User
    When I want to add information using the api "users/registration" with the following values
      | username | success          |
      | email    | success@fake.com |
      | password | success_password |
    Then a proper response should be returned

  @api @user @user_api
  Scenario: As a logged user I cannot register as a new User
    Given I am logged as Ghriim
    When I want to add information using the api "users/registration" with the following values
      | username | failure          |
      | email    | failure@fake.com |
      | password | failure_password |
    Then access should be forbidden

  @api @administrator @user_api
  Scenario: As a logged administrator I cannot register as a new User
    Given I am logged as an Administrator
    When I want to add information using the api "users/registration" with the following values
      | username | failure          |
      | email    | failure@fake.com |
      | password | failure_password |
    Then access should be forbidden
