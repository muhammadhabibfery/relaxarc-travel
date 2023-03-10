<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make(trans('Travel Packages'), countOfAllTravelPackages()),
            Card::make(trans('Transactions'), countOfAllTransactions())
        ];
    }
}
