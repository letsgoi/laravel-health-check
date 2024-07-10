<?php

namespace Letsgoi\HealthCheck\Tests\Console;

use Letsgoi\HealthCheck\HealthCheck;
use Letsgoi\HealthCheck\Tests\Stubs\FakeOkChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class HealthCheckCommandTest extends TestCase
{
    #[Test]
    public function it_should_health_check_with_all_checkers_on_command()
    {
        $this->mock(HealthCheck::class, static function (MockInterface $mock) {
            $mock->shouldReceive('healthCheck')
                ->once()
                ->andReturn(true);
        });

        $this->artisan('health-check')
            ->expectsOutput('All checkers are ok.');
    }

    #[Test]
    public function it_should_health_check_with_one_checker_on_command()
    {
        $this->mock(HealthCheck::class, static function (MockInterface $mock) {
            $mock->shouldReceive('check')
                ->once()
                ->andReturn(true);
        });

        $this->artisan('health-check', ['--checker' => FakeOkChecker::class])
            ->expectsOutput(FakeOkChecker::class . ' checker it\'s ok.');
    }
}
