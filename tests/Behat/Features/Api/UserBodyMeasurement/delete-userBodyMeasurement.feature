Feature:
  Delete an UserBodyMeasurement

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous user I cannot delete a UserBodyMeasurement
    Given I am an anonymous User
    When I want to delete information using the api "users/ghriim/body-measurements"
    Then access should not be authorized

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous user I cannot delete a non existing UserBodyMeasurement
    Given I am an anonymous User
    When I want to delete information using the api "users/not_existing/body-measurements"
    Then access should not be authorized

  @api @user @userBodyMeasurement
  Scenario: As a logged user I cannot delete a UserBodyMeasurement
    Given I am logged as Ghriim
    When I want to delete information using the api "users/ghriim/body-measurements"
    Then an error should be returned

  @api @user @userBodyMeasurement
  Scenario: As a logged user I cannot delete a non existing UserBodyMeasurement
    Given I am logged as Ghriim
    When I want to delete information using the api "users/not_existing/body-measurements"
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot delete a non existing UserBodyMeasurement
    Given I am logged as an Administrator
    When I want to delete information using the api "users/not_existing/body-measurements"
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot delete a UserBodyMeasurement
    Given I am logged as an Administrator
    When I want to delete information using the api "users/ghriim/body-measurements"
    Then an error should be returned
