Feature:
  Validate access to visitor pages

  @page @visitor
  Scenario: As an anonymous user I can access the home page
    Given I am an anonymous User
    When I visit the page "/"
    Then a proper page should be displayed
    And the title of the the page should be "Super Hero Factory"

  @page @user
  Scenario: As a logged user I cannot access the home page
    Given I am logged as Ghriim
    When I visit the page "/"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Dashboard"

  @page @administrator
  Scenario: As a logged user I cannot access the login page
    Given I am logged as an Administrator
    When I visit the page "/"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Admin Dashboard"

  @page @visitor
  Scenario: As an anonymous user I can access the login page
    Given I am an anonymous User
    When I visit the page "/login"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  @page @user
  Scenario: As a logged user I cannot access the login page
    Given I am logged as Ghriim
    When I visit the page "/login"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Dashboard"

  @page @administrator
  Scenario: As a logged user I cannot access the login page
    Given I am logged as an Administrator
    When I visit the page "/login"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Admin Dashboard"

  @page @visitor
  Scenario: As an anonymous user I can access the registration page
    Given I am an anonymous User
    When I visit the page "/register"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Register"

  @page @user
  Scenario: As a logged user I cannot access the registration page
    Given I am logged as Ghriim
    When I visit the page "/register"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Dashboard"

  @page @administrator
  Scenario: As a logged user I cannot access the login page
    Given I am logged as an Administrator
    When I visit the page "/register"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Admin Dashboard"