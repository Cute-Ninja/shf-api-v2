Feature:
  Get the details of a given user

  @api @visitor @user_api
  Scenario: As an anonymous user I cannot access the details of an User over an API call
    Given I am an anonymous User
    When I request the api "users/ghriim"
    Then access should not be authorized

  @api @visitor @user_api
  Scenario: As an anonymous user I cannot access the details of a non existing User over an API call
    Given I am an anonymous User
    When I request the api "users/not_existing"
    Then access should not be authorized

  @api @user @user_api
  Scenario: As a logged user I can access the details of an User over an API call
    Given I am logged as Ghriim
    When I request the api "users/ghriim"
    Then a proper response should be returned

  @api @user @user_api
  Scenario: As a logged user I cannot access the details of a non existing User over an API call
    Given I am logged as Ghriim
    When I request the api "users/not_existing"
    Then no result should be found

  @api @administrator @user_api
  Scenario: As a logged administrator I can access the details of an User over an API call
    Given I am logged as an Administrator
    When I request the api "users/ghriim"
    Then a proper response should be returned
    And the content should be similar to "user_ghriim.json"

  @api @administrator @user_api
  Scenario: As a logged administrator I cannot access the details of a non existing User over an API call
    Given I am logged as an Administrator
    When I request the api "users/not_existing"
    Then no result should be found
