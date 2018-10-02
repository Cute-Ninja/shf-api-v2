Feature:
  Get the details of a given UserBodyMeasurement

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous user I cannot access the details of a UserBodyMeasurement
    Given I am an anonymous User
    When I request the api "users/ghriim/body-measurements"
    Then access should not be authorized

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous user I cannot access the details of a non existing UserBodyMeasurement
    Given I am an anonymous User
    When I request the api "users/not_existing/body-measurements"
    Then access should not be authorized

  @api @user @userBodyMeasurement
  Scenario: As a logged user I can access the details of a UserBodyMeasurement
    Given I am logged as Ghriim
    When I request the api "users/ghriim/body-measurements"
    Then an error should be returned

  @api @user @userBodyMeasurement
  Scenario: As a logged user I cannot access the details of a non existing UserBodyMeasurement
    Given I am logged as Ghriim
    When I request the api "users/not_existing/body-measurements"
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I can access the details of a UserBodyMeasurement
    Given I am logged as an Administrator
    When I request the api "users/ghriim/body-measurements"
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot access the details of a non existing UserBodyMeasurement
    Given I am logged as an Administrator
    When I request the api "users/not_existing/body-measurements"
    Then an error should be returned
