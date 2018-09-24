Feature:
  Get the details of a given user

  @api @visitor @user_api
  Scenario: As an anonymous user I cannot access the details of an User over an API call
    Given I am an anonymous User
    When I request the api "users" with id "ghriim"
    Then access should not be authorized

  @api @user @user_api
  Scenario: As a logged user I can access the details of an User over an API call
    Given I am logged as Ghriim
    When I request the api "users" with id "ghriim"
    Then a proper response should be return

  @api @administrator @user_api
  Scenario: As a logged administrator I cann access the details of an User over an API call
    Given I am logged as an Administrator
    When I request the api "users" with id "ghriim"
    Then a proper response should be return
    And the content should be similar to "user_ghriim.json"
