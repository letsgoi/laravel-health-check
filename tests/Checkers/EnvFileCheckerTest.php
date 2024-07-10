<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Letsgoi\HealthCheck\Checkers\EnvFileChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class EnvFileCheckerTest extends TestCase
{
    protected function tearDown(): void
    {
        @unlink(base_path('.env'));

        parent::tearDown();
    }

    #[Test]
    public function it_should_return_true_if_env_file_exists()
    {
        touch(base_path('.env'));

        $envFileChecker = new EnvFileChecker();

        $this->assertTrue($envFileChecker->check());
    }

    #[Test]
    public function it_should_return_true_if_env_file_not_exists()
    {
        $envFileChecker = new EnvFileChecker();

        $this->assertFalse($envFileChecker->check());
    }
}
