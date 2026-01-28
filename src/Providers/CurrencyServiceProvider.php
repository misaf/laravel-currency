<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Misaf\VendraCurrency\CurrencyPlugin;

final class CurrencyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ('admin' !== $panel->getId()) {
                return;
            }

            $panel->plugin(CurrencyPlugin::make());
        });
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'currency');
    }
}
