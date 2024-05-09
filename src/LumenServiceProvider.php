<?php

namespace Devdojo\ConfigWriter;

use Laravel\Lumen\Application;
use Devdojo\ConfigWriter\ServiceProvider;

class LumenServiceProvider extends ServiceProvider
{
    /** @var  Application */
    protected $app;

    protected function getConfigPath(): string
    {
        return $this->app->getConfigurationPath();
    }
}
