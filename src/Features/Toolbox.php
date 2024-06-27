<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Application;
use Blumilk\BLT\Features\Traits\Authentication;
use Blumilk\BLT\Features\Traits\Database;
use Blumilk\BLT\Features\Traits\Dispatcher;
use Blumilk\BLT\Features\Traits\Eloquent;
use Blumilk\BLT\Features\Traits\Environment;
use Blumilk\BLT\Features\Traits\Http;
use Blumilk\BLT\Features\Traits\Middleware;
use Blumilk\BLT\Features\Traits\Routing;
use Blumilk\BLT\Features\Traits\Session;
use Blumilk\BLT\Features\Traits\Testing;
use Blumilk\BLT\Features\Traits\Translations;

class Toolbox implements Context
{
    use Application;
    use Authentication;
    use Database;
    use Dispatcher;
    use Eloquent;
    use Environment;
    use Http;
    use Middleware;
    use Session;
    use Testing;
    use Translations;
    use Routing;
}
