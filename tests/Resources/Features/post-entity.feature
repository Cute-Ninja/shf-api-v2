Feature:
  Add a new {entity}

  @api @visitor {tag}
  Scenario: As an anonymous User I cannot add a new {entity}
    Given I am an anonymous User
    When I want to add information using the api "{apiUrl}" with the following values
      | | |
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged User I cannot add a new {entity} if my information are incorrect
    Given I am logged as Ghriim
    When I want to add information using the api "{apiUrl}" with the following values
      | | |
    Then form errors should be returned

  @api @user @regenerateDB {tag}
  Scenario: As a logged User I can add a new {entity} if my information are correct
    Given I am logged as Ghriim
    When I want to add information using the api "{apiUrl}" with the following values
      | | |
    Then a proper response should be returned

  @api @administrator {tag}
  Scenario: As a logged administrator I cannot add a new {entity} if my information are incorrect
    Given I am logged as an Administrator
    When I want to add information using the api "{apiUrl}" with the following values
      | | |
    Then form errors should be returned

  @api @administrator @regenerateDB {tag}
  Scenario: As a logged administrator I can add a new {entity} if my information are correct
    Given I am logged as an Administrator
    When I want to add information using the api "{apiUrl}" with the following values
      | | |
    Then a proper response should be returned
