<?php

namespace Letsgoi\HealthCheck;

use Illuminate\Support\Facades\Config;
use Letsgoi\HealthCheck\Contracts\HealthChecker;
use Letsgoi\HealthCheck\Exceptions\HealthCheckerException;

class HealthCheck
{
    /** @var array */
    private $healthCheckers;

    public function __construct()
    {
        $this->healthCheckers = Config::get('laravel_health_check.checkers') ?? [];
    }

    public function check(HealthChecker $checker): bool
    {
        if ($checker->check()) {
            return true;
        }

        throw new HealthCheckerException(get_class($checker) . ' check failed.');
    }

    public function healthCheck(): bool
    {
        $errors = $this->getCheckErrors();

        if (count($errors) > 0) {
            throw new HealthCheckerException(
                "Health check failed:\n\n" . implode("\n", $errors)
            );
        }

        return true;
    }

    public function getCheckErrors(): array
    {
        $errors = [];

        foreach ($this->healthCheckers as $healthChecker) {
            try {
                $this->check(app()->make($healthChecker));
            } catch (HealthCheckerException $healthCheckerException) {
                $errors[] = $healthCheckerException->getMessage();
            }
        }

        return $errors;
    }
}
