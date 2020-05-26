<?php

namespace Letsgoi\HealthCheck\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Facades\HealthCheck;

class HealthCheckController
{
    public function __invoke()
    {
        $healthCheckFails = $this->getHealthCheckFails();

        if (count($healthCheckFails) > 0) {
            return response(['errors' => $healthCheckFails], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(Config::get('laravel_health_check.endpoint.healthy_message'), Response::HTTP_OK);
    }

    private function getHealthCheckFails(): array
    {
        return HealthCheck::getCheckErrors();
    }
}
