Feature:
  Delete an {entity}

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot delete an {entity}
    Given I am an anonymous User
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged user I cannot delete my {entity}
    Given I am logged as Ghriim
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then access should be forbidden

  @api @administrator @regenerateDB {tag}
  Scenario: As a logged administrator I cannot register as a new {entity}
    Given I am logged as an Administrator
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then a proper response should be returned
