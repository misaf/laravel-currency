<?php

declare(strict_types=1);

namespace Misaf\Currency\Filament\Clusters\Resources\Currencies\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Misaf\Currency\Filament\Clusters\Resources\Currencies\CurrencyResource;

final class EditCurrency extends EditRecord
{
    protected static string $resource = CurrencyResource::class;

    public function getBreadcrumb(): string
    {
        return self::$breadcrumb ?? __('filament-panels::resources/pages/edit-record.breadcrumb') . ' ' . __('currency::navigation.currency');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            DeleteAction::make(),
        ];
    }
}
