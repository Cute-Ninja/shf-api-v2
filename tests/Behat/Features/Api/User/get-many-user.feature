Feature:
  Get the list of Users

  @api @visitor @user_api
  Scenario: As an anonymous user I cannot access the list Users over an API call
    Given I am an anonymous User
    When I request the api "users"
    Then access should not be authorized

  @api @user @user_api
  Scenario: As a logged user I can access the list Users over an API call
    Given I am logged as Ghriim
    When I request the api "users"
    Then a proper response should be return

  @api @administrator @user_api
  Scenario: As a logged administrator I access the list Users over an API call
    Given I am logged as an Administrator
    When I request the api "users"
    Then a proper response should be return
    And the content should be similar to "users.json"
