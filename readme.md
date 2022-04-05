![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/blumilksoftware/blt?style=for-the-badge) ![Packagist Version](https://img.shields.io/packagist/v/blumilksoftware/blt?style=for-the-badge) ![Packagist Downloads](https://img.shields.io/packagist/dt/blumilksoftware/blt?style=for-the-badge)

## 🍔 blumilksoftware/blt
BLT for PHP developers: Behat+Laravel toolbox

> Package is still under development.

### Usage
Add the repository to your `composer.json` structure:
```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/blumilksoftware/blt"
  }
],
```

Then update your `require-dev` section:
```json
"require-dev": {
  "blumilksoftware/blt": "dev-main",
},
```

And run:
```
composer install
```

### Development
There are scripts available for package codestyle checking and testing:
```shell
composer cs
composer csf
composer test
```

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
