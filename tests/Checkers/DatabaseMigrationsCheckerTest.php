<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Illuminate\Support\Facades\Artisan;
use Letsgoi\HealthCheck\Checkers\DatabaseMigrationsChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DatabaseMigrationsCheckerTest extends TestCase
{
    #[Test]
    public function it_should_return_true_if_migrations_are_up_to_date()
    {
        Artisan::shouldReceive('call')
            ->withArgs(['migrate', ['--pretend' => true, '--force' => true]])
            ->once();

        Artisan::shouldReceive('output')
            ->once()
            ->andReturn("Nothing to migrate.\n");

        $databaseMigrationsChecker = new DatabaseMigrationsChecker();

        $this->assertTrue($databaseMigrationsChecker->check());
    }

    #[Test]
    public function it_should_return_false_if_migrations_are_not_up_to_date()
    {
        Artisan::shouldReceive('call')
            ->withArgs(['migrate', ['--pretend' => true, '--force' => true]])
            ->once();

        Artisan::shouldReceive('output')
            ->once()
            ->andReturn("Not all migrations were migrated.\n");

        $databaseMigrationsChecker = new DatabaseMigrationsChecker();

        $this->assertFalse($databaseMigrationsChecker->check());
    }
}
