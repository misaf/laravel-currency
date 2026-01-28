<?php

declare(strict_types=1);

namespace Misaf\Currency\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Panel;
use Misaf\Currency\CurrencyPlugin;

final class CurrencyServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ($panel->getId() !== 'admin') {
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
