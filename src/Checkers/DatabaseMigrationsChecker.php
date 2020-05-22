<?php

namespace Letsgoi\HealthCheck\Checkers;

use Illuminate\Support\Facades\Artisan;
use Letsgoi\HealthCheck\Contracts\HealthChecker;

class DatabaseMigrationsChecker implements HealthChecker
{
    private const MESSAGE_OK = 'Nothing to migrate';

    public function check(): bool
    {
        Artisan::call('migrate', ['--pretend' => true, '--force' => true]);

        $output = Artisan::output();

        return $output && preg_match('/' . self::MESSAGE_OK . '/', $output);
    }
}
