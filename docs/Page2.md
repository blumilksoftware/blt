# Behat 

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
Example usage in tests is available in the [Traits](index.md)
