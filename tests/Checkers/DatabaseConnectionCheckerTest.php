<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Letsgoi\HealthCheck\Checkers\DatabaseConnectionChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class DatabaseConnectionCheckerTest extends TestCase
{
    #[Test]
    public function it_should_return_true_if_app_is_database_connection_is_ok()
    {
        $connection = $this->mock(ConnectionInterface::class, static function (MockInterface $mock) {
            $mock->shouldReceive('getPdo')
                ->andReturn(true);
        });

        DB::shouldReceive('connection')
            ->andReturn($connection);

        $databaseConnectionChecker = new DatabaseConnectionChecker();

        $this->assertTrue($databaseConnectionChecker->check());
    }

    #[Test]
    public function it_should_return_false_if_app_is_database_connection_is_ko()
    {
        $connection = $this->mock(ConnectionInterface::class, static function (MockInterface $mock) {
            $mock->shouldReceive('getPdo')
                ->andThrow(new Exception());
        });

        DB::shouldReceive('connection')
            ->andReturn($connection);

        $databaseConnectionChecker = new DatabaseConnectionChecker();

        $this->assertFalse($databaseConnectionChecker->check());
    }
}
