<?php

namespace Letsgoi\HealthCheck\Tests\Stubs;

use Letsgoi\HealthCheck\Contracts\HealthChecker;

class FakeOkChecker implements HealthChecker
{
    public function check(): bool
    {
        return true;
    }
}
