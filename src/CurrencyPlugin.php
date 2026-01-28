<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency;

use Filament\Contracts\Plugin;
use Filament\Panel;

class CurrencyPlugin implements Plugin
{
    public function getId(): string
    {
        return 'vendra-currency';
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
                for: 'Misaf\\VendraCurrency\\Filament\\Clusters',
            )
            ->discoverPages(
                in: __DIR__ . '/Filament/Pages',
                for: 'Misaf\\VendraCurrency\\Filament\\Pages',
            )
            ->discoverResources(
                in: __DIR__ . '/Filament/Resources',
                for: 'Misaf\\VendraCurrency\\Filament\\Resources',
            )
            ->discoverWidgets(
                in: __DIR__ . '/Filament/Widgets',
                for: 'Misaf\\VendraCurrency\\Filament\\Widgets',
            );
    }

    public function boot(Panel $panel): void {}
}
