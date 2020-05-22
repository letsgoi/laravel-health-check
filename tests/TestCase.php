<?php

namespace Letsgoi\HealthCheck\Tests;

use Letsgoi\HealthCheck\HealthCheckServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestClass;

abstract class TestCase extends BaseTestClass
{
    protected function getPackageProviders($app): array
    {
        return [
            HealthCheckServiceProvider::class,
        ];
    }
}
