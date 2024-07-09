<?php

namespace Letsgoi\HealthCheck\Tests\Checkers;

use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Checkers\AppKeyChecker;
use Letsgoi\HealthCheck\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AppKeyCheckerTest extends TestCase
{
    #[Test]
    public function it_should_return_true_if_app_key_is_setted()
    {
        Config::set('app.key', 'ANY_KEY');

        $appKeyChecker = new AppKeyChecker();

        $this->assertTrue($appKeyChecker->check());
    }

    #[Test]
    public function it_should_return_false_if_app_key_is_not_setted()
    {
        Config::set('app.key', null);

        $appKeyChecker = new AppKeyChecker();

        $this->assertFalse($appKeyChecker->check());
    }
}
