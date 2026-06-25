<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Database\Seeders;

use Misaf\VendraCurrency\CurrencyPlugin;
use Misaf\VendraCurrency\Enums\CurrencyCategoryPolicyEnum;
use Misaf\VendraCurrency\Enums\CurrencyPolicyEnum;
use Misaf\VendraSupport\Database\Seeders\PermissionPolicySeeder as BasePermissionPolicySeeder;
use Misaf\VendraTenant\Concerns\RequiresCurrentTenant;

final class PermissionPolicySeeder extends BasePermissionPolicySeeder
{
    use RequiresCurrentTenant;

    protected const string MODULE_NAME = CurrencyPlugin::ID;

    public function run(): void
    {
        $tenant = $this->currentTenant();

        $this->seedPermissionPolicies($tenant->getKey());
    }

    /**
     * @return list<string>
     */
    protected function policies(): array
    {
        return [
            ...array_column(CurrencyCategoryPolicyEnum::cases(), 'value'),
            ...array_column(CurrencyPolicyEnum::cases(), 'value'),
        ];
    }
}
