<?php

namespace Koders\EstimationModule;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EstimationModuleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name("estimation-module")
            ->hasConfigFile()
            ->hasMigrations(['create_estimations_result_tables'])
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub("masterSkill77/estimation-module")
                    ->copyAndRegisterServiceProviderInApp();
            });
    }
}
