Feature:
  Edit a {entity}

  @api @visitor {tag}
  Scenario: As an anonymous User I cannot modify a {entity}
    Given I am an anonymous User
    When I want to modify information using the api "{apiUrl}/id_to_replace" with the following values
      | | |
    Then access should not be authorized

  @api @visitor {tag}
  Scenario: As an anonymous User I cannot modify a non existing {entity}
    Given I am an anonymous User
    When I want to modify information using the api "{apiUrl}/0" with the following values
      | | |
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged User I cannot modify a a non existing {entity}
    Given I am logged as Ghriim
    When I want to modify information using the api "{apiUrl}/0" with the following values
      | | |
    Then no result should be found

  @api @user {tag}
  Scenario: As a logged User I cannot modify a {entity} if my information are incorrect
    Given I am logged as Ghriim
    When I want to modify information using the api "{apiUrl}/id_to_replace" with the following values
      | | |
    Then form errors should be returned

  @api @user @regenerateDB {tag}
  Scenario: As a logged User I can modify a {entity} if my information are correct
    Given I am logged as Ghriim
    When I want to modify information using the api "{apiUrl}/id_to_replace" with the following values
      | | |
    Then a proper response should be returned

  @api @administrator {tag}
  Scenario: As a logged administrator I cannot modify a non existing {entity}
    Given I am logged as an Administrator
    When I want to modify information using the api "{apiUrl}/0" with the following values
      | | |
    Then no result should be found

  @api @administrator {tag}
  Scenario: As a logged administrator I cannot modify a {entity} if my information are incorrect
    Given I am logged as an Administrator
    When I want to modify information using the api "{apiUrl}/id_to_replace" with the following values
      | | |
    Then form errors should be returned

  @api @administrator @regenerateDB {tag}
  Scenario: As a logged administrator I can modify a {entity} if my information are correct
    Given I am logged as an Administrator
    When I want to modify information using the api "{apiUrl}//id_to_replace" with the following values
      | | |
    Then a proper response should be returned
