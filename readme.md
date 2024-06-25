![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/blumilksoftware/blt?style=for-the-badge) ![Packagist Version](https://img.shields.io/packagist/v/blumilksoftware/blt?style=for-the-badge) ![Packagist Downloads](https://img.shields.io/packagist/dt/blumilksoftware/blt?style=for-the-badge)

## 🍔 blumilksoftware/blt
BLT for PHP developers: Behat+Laravel toolbox

> Package is still under development.

### Usage
To start using package if you don't already have Behat initialized in your project:
```
composer require blumilksfotware/blt --dev
php artisan blt:init
```
### Or if you want to do that manually:
Use Composer to get package from the Packagist repository:
```
composer require blumilksfotware/blt --dev
```
Create .env.behat file in your project root directory and set up your environment variables for Behat.
```
cp .env.example .env.behat
```
Initialize Behat in your project:
```
php vendor/bin/behat --init
```
To learn more about Behat visit [Behat documentation](https://docs.behat.org/en/latest/).
### To use in your tests:
Bootstrap BLT in your FeatureContext file:
```
 public function __construct()
    {
        $bootstrapper = new LaravelBootstrapper();
        $bootstrapper->boot();
    }
```
If you want to include all suite of features, you can use:
```
use Blumilk\BLT\Features\Toolbox;
class FeatureContext extends Toolbox implements Context
{...}
```
Or to use selected traits:
```
use Blumilk\BLT\Features\Traits\Eloquent;
class FeatureContext implements Context
{
    use Eloquent;
    ...
}
```

Example usage in tests is available in the [docs](docs).
### Development
There are scripts available for package codestyle checking and testing:
```shell
composer cs
composer csf
composer test
```

#### Docker
There is also the Docker Compose configuration available:
```shell
docker-compose up -d
docker-compose exec php php -v
docker-compose exec php composer -V
```

Please maintain our project guidelines:
* keep issues well described, labeled and in English,
* add issue number to all your commits,
* add issue number to your branch name,
* squash your commits into one commit with standardized name.
