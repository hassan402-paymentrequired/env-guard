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
            ->hasCommand(EnvGuardCommand::class);
    }

    public function register()
    {
        $this->app->singleton(EnvGuard::class, fn () => new EnvGuard);
    }

    public function boot()
    {
        parent::boot();

        $this->app->booted(function () {
            app(EnvGuard::class)->validate();
        });
    }
}
