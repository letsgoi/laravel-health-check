<?php

namespace Letsgoi\HealthCheck;

use Illuminate\Support\ServiceProvider;

class HealthCheckServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishes();
    }

    public function register(): void
    {
        $this->app->bind('health-check', static function () {
            return new HealthCheck();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_health_check.php', 'health-check');
    }

    private function registerPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/laravel_health_check.php' => config_path('laravel_health_check.php'),
        ], 'config');
    }
}
