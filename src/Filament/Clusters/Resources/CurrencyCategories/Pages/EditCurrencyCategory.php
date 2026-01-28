<?php

declare(strict_types=1);

namespace Misaf\Currency\Filament\Clusters\Resources\CurrencyCategories\Pages;

use Misaf\Currency\Filament\Clusters\Resources\CurrencyCategories\CurrencyCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditCurrencyCategory extends EditRecord
{
    protected static string $resource = CurrencyCategoryResource::class;

    public function getBreadcrumb(): string
    {
        return self::$breadcrumb ?? __('filament-panels::resources/pages/edit-record.breadcrumb') . ' ' . __('currency::navigation.currency_category');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            DeleteAction::make(),
        ];
    }
}
