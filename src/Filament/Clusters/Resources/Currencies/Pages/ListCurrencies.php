<?php

declare(strict_types=1);

namespace Misaf\Currency\Filament\Clusters\Resources\Currencies\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Misaf\Currency\Filament\Clusters\Resources\Currencies\CurrencyResource;

final class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    public function getBreadcrumb(): string
    {
        return self::$breadcrumb ?? __('filament-panels::resources/pages/list-records.breadcrumb') . ' ' . __('currency::navigation.currency');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
