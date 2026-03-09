<?php

namespace LaramicStudio\EnvGuard\Commands;

use Illuminate\Console\Command;
use LaramicStudio\EnvGuard\EnvGuard;

class EnvGuardCommand extends Command
{
    public $signature = 'env:check';

    public $description = 'Run .env check against the provided schema in the env-guard.php';

    public function handle(): int
    {
        EnvGuard::validate();
        $this->comment('All done');

        return self::SUCCESS;
    }
}
