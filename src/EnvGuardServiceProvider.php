<?php

namespace LaramicStudio\EnvGuard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LaramicStudio\EnvGuard\Commands\EnvGuardCommand;

class EnvGuardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('env-guard')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_env_guard_table')
            ->hasCommand(EnvGuardCommand::class);
    }
}
