<?php

namespace App\Filament\Widgets;

use App\Models\Aspirasi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GetAspirasi extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Semua total aspirasi', Aspirasi::select()->count()),
        ];
    }
}
