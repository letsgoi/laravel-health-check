<?php

namespace Letsgoi\HealthCheck\Checkers;

use Exception;
use Illuminate\Support\Facades\DB;
use Letsgoi\HealthCheck\Contracts\HealthChecker;

class DatabaseConnectionChecker implements HealthChecker
{
    public function check(): bool
    {
        try {
            DB::connection()->getPdo();
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
