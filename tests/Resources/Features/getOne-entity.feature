Feature:
  Get the details of a given {entity}

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot access the details of a {entity} over an API call
    Given I am an anonymous User
    When I request the api "{apiUrl}/id_to_replace"
    Then access should not be authorized

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot access the details of a non existing {entity} over an API call
    Given I am an anonymous User
    When I request the api "{apiUrl}/not_existing"
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged user I can access the details of a {entity} over an API call
    Given I am logged as Ghriim
    When I request the api "{apiUrl}/id_to_replace"
    Then a proper response should be returned

  @api @user {tag}
  Scenario: As a logged user I cannot access the details of a non existing {entity} over an API call
    Given I am logged as Ghriim
    When I request the api "{apiUrl}/not_existing"
    Then no result should be found

  @api @administrator {tag}
  Scenario: As a logged administrator I can access the details of a {entity} over an API call
    Given I am logged as an Administrator
    When I request the api "{apiUrl}/id_to_replace"
    Then a proper response should be returned
    And the content should be similar to "{entity}.json"

  @api @administrator {tag}
  Scenario: As a logged administrator I cannot access the details of a non existing {entity} over an API call
    Given I am logged as an Administrator
    When I request the api "{apiUrl}/not_existing"
    Then no result should be found
