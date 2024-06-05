![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/blumilksoftware/blt?style=for-the-badge) ![Packagist Version](https://img.shields.io/packagist/v/blumilksoftware/blt?style=for-the-badge) ![Packagist Downloads](https://img.shields.io/packagist/dt/blumilksoftware/blt?style=for-the-badge)

## 🍔 blumilksoftware/blt
BLT for PHP developers: Behat+Laravel toolbox

> Package is still under development.

### Usage
Use Composer to get package from the Packagist repository:
```
composer require blumilksfotware/blt --dev
```

To use the package you need to have behat installed in your project:
```
php composer.phar require --dev behat/behat
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

Bootstrap BLT in your FeatureContext file:
```
 public function __construct()
    {
        $bootstrapper = new LaravelBootstrapper();
        $bootstrapper->boot();
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
