<?php

namespace Letsgoi\HealthCheck\Contracts;

interface HealthChecker
{
    /**
     * This method should return true if the check pass and false if not
     *
     * @return bool
     */
    public function check(): bool;
}
