<?php

namespace Letsgoi\HealthCheck\Tests;

use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Contracts\HealthChecker;
use Letsgoi\HealthCheck\Exceptions\HealthCheckerException;
use Letsgoi\HealthCheck\HealthCheck;
use Letsgoi\HealthCheck\Tests\Stubs\FakeKoChecker;
use Letsgoi\HealthCheck\Tests\Stubs\FakeOkChecker;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class HealthCheckTest extends TestCase
{
    #[Test]
    public function it_should_return_true_on_check_ok_checker()
    {
        $healthCheck = new HealthCheck();

        $checker = $this->mock(HealthChecker::class, static function (MockInterface $mock) {
            $mock->shouldReceive('check')
                ->andReturn(true);
        });

        $this->assertTrue($healthCheck->check($checker));
    }

    #[Test]
    public function it_should_throw_exception_on_check_failed_checker()
    {
        $this->expectException(HealthCheckerException::class);

        $healthCheck = new HealthCheck();

        $checker = $this->mock(HealthChecker::class, static function (MockInterface $mock) {
            $mock->shouldReceive('check')
                ->andReturn(false);
        });

        $healthCheck->check($checker);
    }

    #[Test]
    public function it_should_check_all_active_checkers_and_return_true_if_all_are_ok()
    {
        Config::set('laravel_health_check.checkers', [
            FakeOkChecker::class,
            FakeOkChecker::class,
            FakeOkChecker::class,
        ]);

        $healthCheck = new HealthCheck();

        $this->assertTrue($healthCheck->healthCheck());
    }

    #[Test]
    public function it_should_throw_exception_if_any_of_checkers_is_failing()
    {
        $this->expectException(HealthCheckerException::class);
        $this->expectExceptionMessage(
            "Health check failed:\n\n" .
            FakeKoChecker::class . " check failed.\n" .
            FakeKoChecker::class . ' check failed.',
        );

        Config::set('laravel_health_check.checkers', [
            FakeOkChecker::class,
            FakeKoChecker::class,
            FakeKoChecker::class,
            FakeOkChecker::class,
        ]);

        $healthCheck = new HealthCheck();

        $healthCheck->healthCheck();
    }

    #[Test]
    public function it_should_return_all_errors_of_failing_checkers()
    {
        Config::set('laravel_health_check.checkers', [
            FakeKoChecker::class,
            FakeOkChecker::class,
            FakeKoChecker::class,
        ]);

        $healthCheck = new HealthCheck();

        $this->assertSame(
            [
                FakeKoChecker::class . ' check failed.',
                FakeKoChecker::class . ' check failed.',
            ],
            $healthCheck->getCheckErrors(),
        );
    }
}
