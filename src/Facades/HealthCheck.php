<?php

namespace Letsgoi\HealthCheck\Facades;

use Illuminate\Support\Facades\Facade;

class HealthCheck extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'health-check';
    }
}
