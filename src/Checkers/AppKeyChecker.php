<?php

namespace Letsgoi\HealthCheck\Checkers;

use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Contracts\HealthChecker;

class AppKeyChecker implements HealthChecker
{
    public function check(): bool
    {
        return Config::get('app.key') !== null;
    }
}
