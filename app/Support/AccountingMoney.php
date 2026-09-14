<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Currency;
use App\Settings\GeneralSettings;
use Liberu\Foundation\Settings\Settings\SiteSettings;
use Throwable;

final class AccountingMoney
{
    public static function code(): string
    {
        try {
            $code = Currency::query()->where('is_default', true)->value('code');
            if (is_string($code) && $code !== '') {
                return strtoupper($code);
            }
        } catch (Throwable) {
            // Database or settings may not be ready during early boot.
        }

        $configured = config('accounting.reporting_currency') ?: config('currency.base');

        return strtoupper(is_string($configured) && $configured !== '' ? $configured : 'IDR');
    }

    public static function symbol(): string
    {
        try {
            $symbol = Currency::query()->where('is_default', true)->value('symbol');
            if (is_string($symbol) && $symbol !== '') {
                return $symbol;
            }
        } catch (Throwable) {
        }

        try {
            $fromSettings = app(SiteSettings::class)->site_currency;
            if (is_string($fromSettings) && $fromSettings !== '') {
                return $fromSettings;
            }
        } catch (Throwable) {
        }

        try {
            $fromSettings = app(GeneralSettings::class)->site_currency;
            if (is_string($fromSettings) && $fromSettings !== '') {
                return $fromSettings;
            }
        } catch (Throwable) {
        }

        return match (self::code()) {
            'IDR' => 'Rp',
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            default => self::code(),
        };
    }

    public static function locale(): string
    {
        return self::code() === 'IDR' ? 'id' : (string) config('app.locale', 'en');
    }

    public static function format(float|int|string|null $amount): string
    {
        $number = is_numeric($amount) ? (float) $amount : 0.0;
        $decimals = self::code() === 'IDR' ? 0 : 2;
        $formatted = self::code() === 'IDR'
            ? number_format($number, $decimals, ',', '.')
            : number_format($number, $decimals);

        return self::symbol().' '.$formatted;
    }
}
