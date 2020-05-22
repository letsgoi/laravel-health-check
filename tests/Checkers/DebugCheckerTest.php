<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Checkers\DebugChecker;
use Letsgoi\HealthCheck\Tests\TestCase;

class DebugCheckerTest extends TestCase
{
    /** @test */
    public function it_should_return_true_if_application_is_not_in_debug_mode()
    {
        Config::set('app.debug', false);

        $debugChecker = new DebugChecker();

        $this->assertTrue($debugChecker->check());
    }

    /** @test */
    public function it_should_return_false_if_application_is_in_debug_mode()
    {
        Config::set('app.debug', true);

        $debugChecker = new DebugChecker();

        $this->assertFalse($debugChecker->check());
    }
}
