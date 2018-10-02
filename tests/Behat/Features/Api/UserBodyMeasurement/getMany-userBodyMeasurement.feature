Feature:
  Get the list of UserBodyMeasurements

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous user I cannot access the list of UserBodyMeasurements
    Given I am an anonymous User
    When I request the api "users/body-measurements"
    Then access should not be authorized

  @api @user @userBodyMeasurement
  Scenario: As a logged user I can access the list of UserBodyMeasurements
    Given I am logged as Ghriim
    When I request the api "users/body-measurements"
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I access the list of UserBodyMeasurements
    Given I am logged as an Administrator
    When I request the api "users/body-measurements"
    Then an error should be returned
