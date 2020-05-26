<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Health Checkers
    |
    | Set checkers active on the project.
    |--------------------------------------------------------------------------
    |
    */
    'checkers' => [
        // Letsgoi\HealthCheck\Checkers\Checker::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Health Check Endpoint
    |
    | Enable/disable endpoint, set endpoint path and configure the health check
    | healthy message returned.
    |--------------------------------------------------------------------------
    |
    */
    'endpoint' => [
        'enabled' => env('HEALTH_CHECK_ENDPOINT_ENABLED', true),

        'path' => env('HEALTH_CHECK_ENDPOINT_PATH', '/health-check'),

        'healthy_message' => env('HEALTH_CHECK_ENDPOINT_HEALTHY_MESSAGE', 'Healthy'),
    ],
];
