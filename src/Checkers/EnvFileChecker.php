<?php

namespace Letsgoi\HealthCheck\Checkers;

use Letsgoi\HealthCheck\Contracts\HealthChecker;

class EnvFileChecker implements HealthChecker
{
    public function check(): bool
    {
        return file_exists(base_path('.env'));
    }
}
