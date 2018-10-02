Feature:
  Add a new UserBodyMeasurement

  @api @visitor @userBodyMeasurement
  Scenario: As an anonymous User I cannot add a new UserBodyMeasurement
    Given I am an anonymous User
    When I want to add information using the api "users/body-measurements" with the following values
      | | |
    Then access should not be authorized

  @api @user @userBodyMeasurement
  Scenario: As a logged User I cannot add a new UserBodyMeasurement if my information are incorrect
    Given I am logged as Ghriim
    When I want to add information using the api "users/body-measurements" with the following values
      | | |
    Then an error should be returned

  @api @user @regenerateDB @userBodyMeasurement
  Scenario: As a logged User I cannot add a new UserBodyMeasurement if my information are correct
    Given I am logged as Ghriim
    When I want to add information using the api "users/body-measurements" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot add a new UserBodyMeasurement if my information are incorrect
    Given I am logged as an Administrator
    When I want to add information using the api "users/body-measurements" with the following values
      | | |
    Then an error should be returned

  @api @administrator @userBodyMeasurement
  Scenario: As a logged administrator I cannot add a new UserBodyMeasurement if my information are correct
    Given I am logged as an Administrator
    When I want to add information using the api "users/body-measurements" with the following values
      | | |
    Then an error should be returned
