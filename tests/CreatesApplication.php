<?php

namespace Tests;

use Exception;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        if ($app->configurationIsCached()) {
            throw new Exception('Your Configuration is chached. Any variable in phpunit.xml did not take effect.');
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
