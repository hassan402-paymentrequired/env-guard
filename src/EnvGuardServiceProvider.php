<?php

namespace LaramicStudio\EnvGuard;

use LaramicStudio\EnvGuard\Commands\EnvGuardCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EnvGuardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('env-guard')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_env_guard_table')
            ->hasCommand(EnvGuardCommand::class);
    }

    public function boot()
    {

            $this->app->afterLoadingEnvironment( function () {
                EnvGuard::validate();
            });

    }
}
