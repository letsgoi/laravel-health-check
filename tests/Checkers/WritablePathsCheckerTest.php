<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Illuminate\Filesystem\Filesystem;
use Letsgoi\HealthCheck\Checkers\WritablePathsChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class WritablePathsCheckerTest extends TestCase
{
    #[Test]
    public function it_should_return_true_if_storage_and_cache_paths_are_writable()
    {
        $this->mock(Filesystem::class, static function (MockInterface $mock) {
            $mock->shouldReceive('isWritable')
                ->with(base_path('bootstrap/cache'))
                ->once()
                ->andReturn(true);

            $mock->shouldReceive('isWritable')
                ->with(base_path('storage'))
                ->once()
                ->andReturn(true);
        });

        $writablePathsChecker = new WritablePathsChecker();

        $this->assertTrue($writablePathsChecker->check());
    }

    #[Test]
    public function it_should_return_false_if_cache_path_is_not_writable()
    {
        $this->mock(Filesystem::class, static function (MockInterface $mock) {
            $mock->shouldReceive('isWritable')
                ->with(base_path('bootstrap/cache'))
                ->once()
                ->andReturn(false);
        });

        $writablePathsChecker = new WritablePathsChecker();

        $this->assertFalse($writablePathsChecker->check());
    }

    #[Test]
    public function it_should_return_false_if_storage_path_is_not_writable()
    {
        $this->mock(Filesystem::class, static function (MockInterface $mock) {
            $mock->shouldReceive('isWritable')
                ->with(base_path('bootstrap/cache'))
                ->once()
                ->andReturn(true);

            $mock->shouldReceive('isWritable')
                ->with(base_path('storage'))
                ->once()
                ->andReturn(false);
        });

        $writablePathsChecker = new WritablePathsChecker();

        $this->assertFalse($writablePathsChecker->check());
    }
}
