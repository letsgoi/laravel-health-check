<?php

namespace Letsgoi\HealthCheck\Console;

use Illuminate\Console\Command;
use Letsgoi\HealthCheck\HealthCheck;

class HealthCheckCommand extends Command
{
    /** @var string */
    protected $signature = 'health-check
                            {--checker : Check only specified checker. If not, all defined at config will be checked}';

    /** @var string */
    protected $description = 'Perform health check with checkers defined at config or specify one';

    /** @var HealthCheck */
    private $healthCheck;

    public function __construct(HealthCheck $healthCheck)
    {
        parent::__construct();

        $this->healthCheck = $healthCheck;
    }

    public function handle(): void
    {
        $this->info('Running health checker...');

        if ($this->option('checker')) {
            $this->healthCheck->check(app()->make($this->option('checker')));

            $this->info($this->option('checker') . ' checker it\'s ok.');

            return;
        }

        $this->healthCheck->healthCheck();
        $this->info('All checkers are ok.');
    }
}
