Feature:
  Validate that visitor pages are accessible to anonymous users but not to logged in ones.

  Scenario: As an anonymous user I cannot access the admin dashboard page
    Given I am an anonymous User
    When I visit the page "/admin/dashboard"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  Scenario: As Ghriim (a logged user) I cannot access the admin dashboard page
    Given I am logged as Ghriim
    When I visit the page "/admin/dashboard"
    Then access should be refused

  Scenario: As a logged user I cannot access the admin dashboard page
    Given I am logged as an Administrator
    When I visit the page "/admin/dashboard"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Admin Dashboard"

  Scenario: As an anonymous user I cannot access the admin user page
    Given I am an anonymous User
    When I visit the page "/admin/user"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Login"

  Scenario: As Ghriim (a logged user) I cannot access the admin user page
    Given I am logged as Ghriim
    When I visit the page "/admin/user"
    Then access should be refused

  Scenario: As a logged user I can access the admin user page
    Given I am logged as an Administrator
    When I visit the page "/admin/user"
    Then a proper page should be displayed
    And the title of the the page should be "SHF - Utilisateurs"