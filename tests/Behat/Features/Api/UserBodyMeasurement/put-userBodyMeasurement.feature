Feature:
  Edit a UserBodyMeasurement

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous User I cannot modify a UserBodyMeasurement
    Given I am an anonymous User
    When I want to modify information using the api "users/ghriim/body-measurements" with the following values
      | | |
    Then access should not be authorized

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous User I cannot modify a non existing UserBodyMeasurement
    Given I am an anonymous User
    When I want to modify information using the api "users/not_existing/body-measurements" with the following values
      | | |
    Then access should not be authorized

  @api @user @userBodyMeasurement
  Scenario: As a logged User I cannot modify a a non existing UserBodyMeasurement
    Given I am logged as Ghriim
    When I want to modify information using the api "users/not_existing/body-measurements" with the following values
      | | |
    Then no result should be found

  @api @user @userBodyMeasurement
  Scenario: As a logged User I cannot modify a UserBodyMeasurement if my information are incorrect
    Given I am logged as Ghriim
    When I want to modify information using the api "users/ghriim/body-measurements" with the following values
      | height | 12 |
      | weight | 52 |
    Then form errors should be returned

  @api @user @regenerateDB @userBodyMeasurement
  Scenario: As a logged User I can modify a UserBodyMeasurement if my information are correct
    Given I am logged as Ghriim
    When I want to modify information using the api "users/ghriim/body-measurements" with the following values
      | height | 181 |
      | weight |  95 |
    Then a proper response should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot modify a non existing UserBodyMeasurement
    Given I am logged as an Administrator
    When I want to modify information using the api "users/not_existing/body-measurements" with the following values
      | height | 181 |
      | weight |  95 |
    Then no result should be found

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot modify a UserBodyMeasurement if my information are incorrect
    Given I am logged as an Administrator
    When I want to modify information using the api "users/ghriim/body-measurements" with the following values
      | height | 12 |
      | weight | 52 |
    Then form errors should be returned

  @api @administrator @regenerateDB @userBodyMeasurement
  Scenario: As a logged administrator I can modify a UserBodyMeasurement if my information are correct
    Given I am logged as an Administrator
    When I want to modify information using the api "users/ghriim/body-measurements" with the following values
      | height | 181 |
      | weight |  95 |
    Then a proper response should be returned
