<?php

namespace Misaf\Currency;

use Filament\Contracts\Plugin;
use Filament\Panel;

class CurrencyPlugin implements Plugin
{
    public function getId(): string
    {
        return 'currency';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverClusters(
                in: __DIR__ . '/Filament/Clusters',
                for: 'Misaf\\Currency\\Filament\\Clusters',
            )
            ->discoverPages(
                in: __DIR__ . '/Filament/Pages',
                for: 'Misaf\\Currency\\Filament\\Pages',
            )
            ->discoverResources(
                in: __DIR__ . '/Filament/Resources',
                for: 'Misaf\\Currency\\Filament\\Resources',
            )
            ->discoverWidgets(
                in: __DIR__ . '/Filament/Widgets',
                for: 'Misaf\\Currency\\Filament\\Widgets',
            );
    }

    public function boot(Panel $panel): void
    {
    }
}