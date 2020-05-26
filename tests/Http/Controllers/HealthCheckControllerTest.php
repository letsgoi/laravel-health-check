<?php

namespace Letsgoi\HealthCheck\Tests\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Facades\HealthCheck;
use Letsgoi\HealthCheck\Tests\TestCase;

class HealthCheckControllerTest extends TestCase
{
    /** @test */
    public function it_should_return_ok_if_all_check_passed_on_endpoint()
    {
        Config::set('laravel_health_check.endpoint.healthy_message', 'ok');

        HealthCheck::shouldReceive('getCheckErrors')
            ->once()
            ->andReturn([]);

        $this->get('/health-check')
            ->assertSee('ok');
    }

    /** @test */
    public function it_should_return_server_error_with_check_errors()
    {
        HealthCheck::shouldReceive('getCheckErrors')
            ->once()
            ->andReturn([
                'Check one error',
                'Check two error',
            ]);

        $this->get('/health-check')
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertJson([
                'errors' => [
                    'Check one error',
                    'Check two error',
                ]
            ]);
    }
}
