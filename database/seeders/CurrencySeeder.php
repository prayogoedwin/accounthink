<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Team;
use App\Settings\GeneralSettings;
use Illuminate\Database\Seeder;
use Liberu\Foundation\Settings\Settings\SiteSettings;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $teamId = Team::query()->value('id');

        Currency::query()->update(['is_default' => false]);

        $currencies = [
            ['code' => 'IDR', 'name' => 'Rupiah Indonesia', 'symbol' => 'Rp', 'is_default' => true],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'is_default' => false],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'is_default' => false],
            ['code' => 'GBP', 'name' => 'Pound Sterling', 'symbol' => '£', 'is_default' => false],
        ];

        foreach ($currencies as $currency) {
            Currency::query()->updateOrCreate(
                ['code' => $currency['code']],
                [
                    ...$currency,
                    'team_id' => $teamId,
                ],
            );
        }

        try {
            $general = app(GeneralSettings::class);
            $general->site_currency = 'Rp';
            $general->site_country = $general->site_country ?: 'Indonesia';
            $general->save();
        } catch (\Throwable) {
        }

        try {
            $site = app(SiteSettings::class);
            $site->site_currency = 'Rp';
            $site->site_country = $site->site_country ?: 'Indonesia';
            $site->save();
        } catch (\Throwable) {
        }
    }
}
