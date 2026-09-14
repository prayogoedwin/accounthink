<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Services\GeneralLedgerService;
use App\Support\AccountingMoney;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialDashboard extends BaseWidget
{
    protected ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    #[\Override]
    protected function getStats(): array
    {
        // Resolve via the container: GeneralLedgerService needs ExchangeRateService
        // injected, so `new` would fatal at runtime.
        /** @var array{revenue: float, expenses: float, netIncome: float, revenueChart: array<float>, expensesChart: array<float>, netIncomeChart: array<float>} $metrics */
        $metrics = app(GeneralLedgerService::class)->getKeyMetrics();

        return [
            Stat::make('Total Revenue', AccountingMoney::format($metrics['revenue']))
                ->description('Total revenue this month')
                ->chart($metrics['revenueChart'])
                ->color('success'),

            Stat::make('Total Expenses', AccountingMoney::format($metrics['expenses']))
                ->description('Total expenses this month')
                ->chart($metrics['expensesChart'])
                ->color('danger'),

            Stat::make('Net Income', AccountingMoney::format($metrics['netIncome']))
                ->description('Net income this month')
                ->chart($metrics['netIncomeChart'])
                ->color($metrics['netIncome'] >= 0 ? 'success' : 'danger'),
        ];
    }
}
