<?php

namespace Letsgoi\HealthCheck\Checkers;

use Illuminate\Filesystem\Filesystem;
use Letsgoi\HealthCheck\Contracts\HealthChecker;

class WritablePathsChecker implements HealthChecker
{
    private const WRITABLE_PATHS = [
        'bootstrap/cache',
        'storage',
    ];

    public function check(): bool
    {
        $filesystem = app()->make(Filesystem::class);

        foreach (self::WRITABLE_PATHS as $path) {
            if (!$filesystem->isWritable(base_path($path))) {
                return false;
            }
        }

        return true;
    }
}
