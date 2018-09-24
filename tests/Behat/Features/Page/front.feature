Feature:
  Validate access to user logged in pages

  @page @visitor
  Scenario: As an anonymous user I cannot access the user dashboard
    Given I am an anonymous User
    When I visit the page "/front/dashboard"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  @page @user
  Scenario: As Ghriim (a logged user) I can access the user dashboard
    Given I am logged as Ghriim
    When I visit the page "/front/dashboard"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Dashboard"

  @page @visitor
  Scenario: As an anonymous user I cannot access the user profile
    Given I am an anonymous User
    When I visit the page "/front/profile"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  @page @user
  Scenario: As Ghriim (a logged user) I can access my profile
    Given I am logged as Ghriim
    When I visit the page "/front/profile"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Mon profil"

  @page @visitor
  Scenario: As an anonymous user I cannot access the page listing all the workouts
    Given I am an anonymous User
    When I visit the page "/front/workouts"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  @page @user
  Scenario: As Ghriim (a logged user) I can access the page listing all the workouts
    Given I am logged as Ghriim
    When I visit the page "/front/workouts"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Entraînements"