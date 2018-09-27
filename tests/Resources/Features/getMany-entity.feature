Feature:
  Get the list of {entity}s

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot access the list {entity}s over an API call
    Given I am an anonymous User
    When I request the api "{apiUrl}"
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged user I can access the list {entity}s over an API call
    Given I am logged as Ghriim
    When I request the api "{apiUrl}"
    Then a proper response should be returned
    And the content should be similar to "{entity}s.json"

  @api @administrator {tag}
  Scenario: As a logged administrator I access the list {entity}s over an API call
    Given I am logged as an Administrator
    When I request the api "{apiUrl}"
    Then a proper response should be returned
    And the content should be similar to "{entity}s.json"
