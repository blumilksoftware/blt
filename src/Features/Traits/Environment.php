<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Bootstrapping\LaravelBootstrapper;

trait Environment
{
    /**
     * @Transform table:config,value
     */
    public function castConfigBoolValues(TableNode $configTable): array
    {
        $config = [];

        foreach ($configTable as $row) {
            $key = $row["config"];
            $value = $row["value"];

            if (in_array($value, ["true", "false"], true)) {
                $value = $value === "true";
            }
            $config[$key] = $value;
        }

        return $config;
    }

    /**
     * @Given application is booted with config:
     */
    public function applicationIsBootedWithConfig(array $config): void
    {
        $bootstrap = new LaravelBootstrapper();
        $bootstrap->setConfigOverrides($config);

        if (array_key_exists("app.env", $config)) {
            $bootstrap->setEnvironmentType($config["app.env"]);
        }

        $bootstrap->boot();
    }
}
