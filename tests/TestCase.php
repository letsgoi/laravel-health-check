<?php

namespace Letsgoi\HealthCheck\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Letsgoi\HealthCheck\HealthCheckServiceProvider;
use Letsgoi\HealthCheck\Tests\Stubs\ConsoleKernel;
use Orchestra\Testbench\TestCase as BaseTestClass;

abstract class TestCase extends BaseTestClass
{
    protected function getPackageProviders($app): array
    {
        return [
            HealthCheckServiceProvider::class,
        ];
    }

    /**
     * @param  Application  $app
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app): void
    {
        $app->singleton(Kernel::class, ConsoleKernel::class);
    }
}
