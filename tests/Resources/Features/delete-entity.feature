Feature:
  Delete an {entity}

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot delete a {entity}
    Given I am an anonymous User
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then access should not be authorized

  @api @visitor {tag}
  Scenario: As an anonymous user I cannot delete a non existing {entity}
    Given I am an anonymous User
    When I want to delete information using the api "{apiUrl}/0"
    Then access should not be authorized

  @api @user {tag}
  Scenario: As a logged user I cannot delete a {entity}
    Given I am logged as Ghriim
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then access should be forbidden

  @api @user {tag}
  Scenario: As a logged user I cannot delete a non existing {entity}
    Given I am logged as Ghriim
    When I want to delete information using the api "{apiUrl}/0"
    Then access should be forbidden

  @api @administrator {tag}
  Scenario: As a logged administrator I cannot delete a non existing {entity}
    Given I am logged as an Administrator
    When I want to delete information using the api "{apiUrl}/0"
    Then no result should be found

  @api @administrator @regenerateDB {tag}
  Scenario: As a logged administrator I can delete a {entity}
    Given I am logged as an Administrator
    When I want to delete information using the api "{apiUrl}/id_to_replace"
    Then a proper response should be returned
