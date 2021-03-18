## Eloquent
Use `Blumilk\BLT\Features\Eloquent` context to asserts Eloquent queries results. 

```gherkin
@eloquent @users
Feature: Test if users are seeded properly

  Scenario: Users seeder is ran
    Given UsersSeeder is ran
    Then there should be 5 users in database
```
