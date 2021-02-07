[![Latest Stable Version](https://poser.pugx.org/krzysztofrewak/larahat/v/stable)](https://packagist.org/packages/krzysztofrewak/larahat) [![Total Downloads](https://poser.pugx.org/krzysztofrewak/larahat/downloads)](https://packagist.org/packages/krzysztofrewak/larahat) [![License](https://poser.pugx.org/krzysztofrewak/larahat/license)](https://packagist.org/packages/krzysztofrewak/larahat)

**Larahat** extension is an extremely simple way to start behaviour-driven development with **Lara**vel framework and Be**hat**. 

## Installation
Just use composer, it will add required classes to your `vendor` directory at `Larahat` namespace:
```
composer require krzysztofrewak/larahat --dev
```

## Usage
Locate your Behat configuration file (usually it's a `behat.yml`) and add `Larahat\BehatExtension` to your `extensions` list.  You can also provide a custom `.env` filename via `env` variable, but by default it will be always `.env.behat`.

```yaml
default:
  extensions:
    KrzysztofRewak\Larahat\BehatExtension:
      env: ".env.behat"
```

From now, in your context files you are able to use `app()` helper for retrieving your bootstrapped Laravel application. For example, you can handle requests directly into your application like that:   
```php
/**
 * @When :method request is sent to :endpoint endpoint
 * @param string $method
 * @param string $endpoint
 */
public function requestIsSentToEndpoint(string $method, string $endpoint): void
{
    $request = Request::create($endpoint, $method);
    app()->handle($request);
}
```

### Helpers
* `KrzysztofRewak\Larahat\Helpers\DisablingThrottling` trait added to your context helps with disabling throttling middleware;
* `KrzysztofRewak\Larahat\Helpers\RefreshDatabase` trait added to your context helps with refreshing database with every scenario;
* `KrzysztofRewak\Larahat\Helpers\SimpleRequesting` trait added to your context helps with sending requests and receiving responses from your application.

## Development
You can use Composer in a container if you want to:
```
docker-compose run -w /application -u "$(id -u):$(id -g)" composer install
```
