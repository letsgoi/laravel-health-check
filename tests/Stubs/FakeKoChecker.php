<?php

namespace Letsgoi\HealthCheck\Tests\Stubs;

use Letsgoi\HealthCheck\Contracts\HealthChecker;

class FakeKoChecker implements HealthChecker
{
    public function check(): bool
    {
        return false;
    }
}
