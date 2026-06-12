<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Providers;

use Filament\Panel;
use Illuminate\Foundation\Console\AboutCommand;
use Misaf\VendraCurrency\Console\Commands\SeedCommand;
use Misaf\VendraCurrency\CurrencyPlugin;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class CurrencyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('vendra-currency')
            ->hasTranslations()
            ->hasMigrations([
                'create_currencies_table'
            ])
            ->hasCommands(SeedCommand::class)
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command->askToStarRepoOnGitHub('misaf/vendra-currency');
            });
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ('admin' !== $panel->getId()) {
                return;
            }

            $panel->plugin(CurrencyPlugin::make());
        });
    }

    public function packageBooted(): void
    {
        AboutCommand::add('Vendra Currency', fn() => ['Version' => 'dev-master']);
    }
}
