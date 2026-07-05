<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Database\Seeders;

use Illuminate\Support\Facades\Validator;
use Misaf\VendraCurrency\Database\Factories\CurrencyCategoryFactory;
use Misaf\VendraCurrency\Database\Factories\CurrencyFactory;
use Misaf\VendraCurrency\Models\Currency;
use Misaf\VendraCurrency\Models\CurrencyCategory;
use Misaf\VendraSupport\Concerns\RequiresCurrentTenant;
use Misaf\VendraSupport\Database\Seeders\DemoContentSeeder as BaseDemoContentSeeder;
use Misaf\VendraTenant\Models\Tenant;

final class DemoContentSeeder extends BaseDemoContentSeeder
{
    use RequiresCurrentTenant;

    protected function seedFactories(): void
    {
        $tenant = $this->currentTenant();

        $this->seedFactoryRecords($tenant);
    }

    /**
     * @param list<array<string, mixed>> $records
     */
    protected function seedFixtures(array $records): void
    {
        $tenant = $this->currentTenant();

        foreach ($records as $record) {
            $this->seedFixtureRecord($tenant, $record);
        }
    }

    protected function seedFactoryRecords(Tenant $tenant): void
    {
        CurrencyCategoryFactory::new()
            ->forTenant($tenant)
            ->enabled()
            ->count(2)
            ->create()
            ->each(fn(CurrencyCategory $currencyCategory): mixed => CurrencyFactory::new()
                ->forCategory($currencyCategory)
                ->enabled()
                ->count(2)
                ->create());
    }

    protected function seedFixtureRecord(Tenant $tenant, array $record): void
    {
        $data = $this->validatedFixtureRecord($record);

        $this->handleSeedFixtureRecord($tenant, $data);
    }

    /**
     * @param array{
     *     name: string,
     *     description: string,
     *     slug: string,
     *     status: bool,
     *     currencies: list<array{
     *         name: string,
     *         description: string,
     *         slug: string,
     *         iso_code: string,
     *         conversion_rate: float,
     *         decimal_place: int,
     *         buy_price: int,
     *         sell_price: int,
     *         is_default: bool,
     *         position: int,
     *         status: bool
     *     }>
     * } $data
     */
    private function handleSeedFixtureRecord(Tenant $tenant, array $data): void
    {
        $currencyCategory = new CurrencyCategory([
            'name'        => $data['name'],
            'description' => $data['description'],
            'slug'        => $data['slug'],
            'status'      => $data['status'],
        ]);

        $currencyCategory->tenant_id = $tenant->id;
        $currencyCategory->save();

        foreach ($data['currencies'] as $currencyRecord) {
            $this->handleCurrencyFixtureRecord($tenant, $currencyCategory, $currencyRecord);
        }
    }

    /**
     * @param array{
     *     name: string,
     *     description: string,
     *     slug: string,
     *     iso_code: string,
     *     conversion_rate: float,
     *     decimal_place: int,
     *     buy_price: int,
     *     sell_price: int,
     *     is_default: bool,
     *     position: int,
     *     status: bool
     * } $currencyRecord
     */
    private function handleCurrencyFixtureRecord(Tenant $tenant, CurrencyCategory $currencyCategory, array $currencyRecord): void
    {
        $currency = new Currency([
            'currency_category_id' => $currencyCategory->id,
            'name'                 => $currencyRecord['name'],
            'description'          => $currencyRecord['description'],
            'slug'                 => $currencyRecord['slug'],
            'iso_code'             => $currencyRecord['iso_code'],
            'conversion_rate'      => $currencyRecord['conversion_rate'],
            'decimal_place'        => $currencyRecord['decimal_place'],
            'buy_price'            => $currencyRecord['buy_price'],
            'sell_price'           => $currencyRecord['sell_price'],
            'is_default'           => $currencyRecord['is_default'],
            'position'             => $currencyRecord['position'],
            'status'               => $currencyRecord['status'],
        ]);

        $currency->tenant_id = $tenant->id;
        $currency->save();
    }

    /**
     * @param array<string, mixed> $record
     *
     * @return array{
     *     name: string,
     *     description: string,
     *     slug: string,
     *     status: bool,
     *     currencies: list<array{
     *         name: string,
     *         description: string,
     *         slug: string,
     *         iso_code: string,
     *         conversion_rate: float,
     *         decimal_place: int,
     *         buy_price: int,
     *         sell_price: int,
     *         is_default: bool,
     *         position: int,
     *         status: bool
     *     }>
     * }
     */
    private function validatedFixtureRecord(array $record): array
    {
        /** @var array{
         *     name: string,
         *     description: string,
         *     slug: string,
         *     status: bool,
         *     currencies: list<array{
         *         name: string,
         *         description: string,
         *         slug: string,
         *         iso_code: string,
         *         conversion_rate: float,
         *         decimal_place: int,
         *         buy_price: int,
         *         sell_price: int,
         *         is_default: bool,
         *         position: int,
         *         status: bool
         *     }>
         * } $validated
         */
        $validated = Validator::make(
            data: $record,
            rules: [
                'name'                         => ['required', 'string'],
                'description'                  => ['required', 'string'],
                'slug'                         => ['required', 'string'],
                'status'                       => ['required', 'boolean'],
                'currencies'                   => ['required', 'array', 'list'],
                'currencies.*'                 => ['required', 'array:name,description,slug,iso_code,conversion_rate,decimal_place,buy_price,sell_price,is_default,position,status'],
                'currencies.*.name'            => ['required', 'string'],
                'currencies.*.description'     => ['required', 'string'],
                'currencies.*.slug'            => ['required', 'string'],
                'currencies.*.iso_code'        => ['required', 'string'],
                'currencies.*.conversion_rate' => ['required', 'numeric'],
                'currencies.*.decimal_place'   => ['required', 'integer'],
                'currencies.*.buy_price'       => ['required', 'integer'],
                'currencies.*.sell_price'      => ['required', 'integer'],
                'currencies.*.is_default'      => ['required', 'boolean'],
                'currencies.*.position'        => ['required', 'integer'],
                'currencies.*.status'          => ['required', 'boolean'],
            ],
        )->validate();

        return $validated;
    }

}
