<?php

namespace Letsgoi\HealthCheck;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Letsgoi\HealthCheck\Console\HealthCheckCommand;
use Letsgoi\HealthCheck\Http\Controllers\HealthCheckController;

class HealthCheckServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishes();
    }

    public function register(): void
    {
        $this->registerCommands();

        $this->app->bind('health-check', static function () {
            return new HealthCheck();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_health_check.php', 'laravel_health_check');

        $this->registerRoutes();
    }

    private function registerPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/laravel_health_check.php' => config_path('laravel_health_check.php'),
        ], 'config');
    }

    private function registerCommands(): void
    {
        $this->commands([
            HealthCheckCommand::class,
        ]);
    }

    private function registerRoutes(): void
    {
        if ($this->app['config']->get('laravel_health_check.endpoint.enabled')) {
            Route::get(
                $this->app['config']->get('laravel_health_check.endpoint.path'),
                HealthCheckController::class
            );
        }
    }
}
