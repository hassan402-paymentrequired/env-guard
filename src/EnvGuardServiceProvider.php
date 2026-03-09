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

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/env-guard.php',
            'env-guard'
        );

        $this->app->singleton(EnvGuard::class, fn () => new EnvGuard);
    }

    public function boot()
    {

        $this->app->afterLoadingEnvironment(function () {
            EnvGuard::validate();
        });

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/env-guard.php' => config_path('env-guard.php'),
            ], 'env-guard');
        }

    }
}
