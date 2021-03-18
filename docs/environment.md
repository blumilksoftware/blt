## Environment
Use `Blumilk\BLT\Features\Environment` context to manipulate boot configuration on the fly. For example, you can change `app` variable `env` value to simulate other environments:

```gherkin
@telescope @views
Feature: Test if Telescope works properly

  Scenario: User is requesting telescope when environment is local
    Given application is booted with config:
      | config  | value |
      | app.env | local |
    Given a user is requesting "/telescope"
    When a request is sent
    Then a response status code should be "200"

  Scenario: User is requesting telescope when environment is production
    Given application is booted with config:
      | config  | value      |
      | app.env | production |
    Given a user is requesting "/telescope"
    When a request is sent
    Then a response status code should be "404"
```