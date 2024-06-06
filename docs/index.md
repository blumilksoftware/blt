# Traits

In this section, we have context toolkits that make it easier to test your Laravel applications with Behat.

Use `Blumilk\BLT\Features\Eloquent` context to asserts Eloquent queries results. 

```gherkin
@eloquent @users
Feature: Test if users are seeded properly

  Scenario: Users seeder is ran
    Given UsersSeeder is ran
    Then there should be 5 users in database
```

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

## Application

Use `Blumilk\BLT\Features\Application` context to mock services in the application container.

```gherkin
@application @mock
Feature: Test if services are mocked properly

  Scenario: Mock a single service
    Given there is "SomeService" service mocked with "SomeMock"

  Scenario: Mock multiple services
    Given there are services mocked:
      | service       | mock        |
      | SomeService   | SomeMock    |
      | AnotherService| AnotherMock |
```
A `Blumilk\BLT\Features\Application` can be used to replace services in the application container with mock implementations. For example, you can mock a single service to simulate different behaviors:

```gherkin
@application @services
Feature: Test service mocking

  Scenario: Mock a single service
    Given there is "App\Services\PaymentService" service mocked with "App\Mocks\MockPaymentService"

  Scenario: Mock multiple services
    Given there are services mocked:
      | service                      | mock                         |
      | App\Services\EmailService    | App\Mocks\MockEmailService   |
      | App\Services\LoggingService  | App\Mocks\MockLoggingService |

```

## Authentication

Use `Blumilk\BLT\Features\Authentication` context to handle user authentication in tests.
This allows you to simulate different authentication states and validate authentication-related functionality.

```gherkin
@authentication @login
Feature: Test user authentication

  Scenario: User is authenticated
    Given user is authenticated in session as "test@example.com" in "email" field
    Then user authenticated in session has "test@example.com" value in "email" field

  Scenario: No user is authenticated
    Given there is no user authenticated in session
    Then no user is authenticated in session
```

## Database

Use `Blumilk\BLT\Features\Database` context to manage database states during tests. This allows you to refresh, seed, and run specific seeders on your database to ensure it is in the desired state before running your tests.

```gherkin
@database @migration
Feature: Test database state management

  Scenario: Refresh database without seeding
    Given there's refreshed database
    Then the database should be empty

  Scenario: Refresh and seed database
    Given there's refreshed and seeded database
    Then the database should have the seeded data

  Scenario: Run specific seeder
    Given "UsersTableSeeder" seeder has been ran
    Then the database should have users table seeded
```

## Http

Use `Blumilk\BLT\Features\Http` context to simulate HTTP requests and assertions on responses. This allows you to interact with your application's endpoints and verify the responses.

```gherkin
@http @request @endpoint @testing
Feature: Test HTTP requests and responses

  Scenario: Send a basic HTTP request
    Given a user is requesting :url
    When a request is sent
    Then a response status code should be 200

  Scenario: Send a POST request with form parameters to the login endpoint
    Given a user is requesting the login endpoint using POST method
    And request form params contains:
      | username | name       |
      | password | password123|
    When a request is sent
    Then a response status code should be 200

  Scenario: Verify response HTML contains CSRF token
    Given a response HTML should contain CSRF token
    When a request is sent
    Then a response HTML should contain CSRF token
```

## Middleware

Use `Blumilk\BLT\Features\Middleware` context to manage middleware behavior.

```gherkin
@middleware @testing
Feature: Test middleware behavior

  Scenario: Disable a single middleware
    Given there is ":middleware" middleware disabled
    Then ":middleware" middleware should be disabled

  Scenario: Disable multiple middlewares
    Given there are middlewares disabled:
      | middleware1      |
      | middleware2      |
      | AnotherMiddleware|
    Then the specified middlewares should be disabled

  Scenario: Disable throttling middleware
    Given there's throttling middleware disabled
    Then throttling middleware should be disabled

  Scenario: Disable CSRF protection middleware
    Given there's CSRF protection middleware disabled
    Then CSRF protection middleware should be disabled
```

## Session

Use the `Blumilk\BLT\Features\Traits\Session` context to assert session flash messages, particularly for errors.

```gherkin
@session @flash @errors
Feature: Test session flash messages

  Scenario: Session flashes errors
    Then a session flashes errors:
      | key     | index | message           |
      | field1 | 0     | Error message one  |
      | field2 | 0     | Error message two  |
      | field3 | 1     | Error message two  |

  Scenario: Session flashes no errors
    Given a session flashes no errors
```
