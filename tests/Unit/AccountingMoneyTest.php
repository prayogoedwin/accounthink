<?php

declare(strict_types=1);

use App\Models\Currency;
use App\Support\AccountingMoney;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('formats amounts in Indonesian rupiah by default', function () {
    Currency::query()->create([
        'code' => 'IDR',
        'name' => 'Rupiah Indonesia',
        'symbol' => 'Rp',
        'is_default' => true,
    ]);

    expect(AccountingMoney::code())->toBe('IDR')
        ->and(AccountingMoney::symbol())->toBe('Rp')
        ->and(AccountingMoney::locale())->toBe('id')
        ->and(AccountingMoney::format(1250000))->toBe('Rp 1.250.000');
});
