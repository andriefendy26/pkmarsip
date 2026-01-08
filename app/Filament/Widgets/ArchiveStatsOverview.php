<?php

namespace App\Filament\Widgets;

use App\Models\Dokumen;
use App\Models\Peminjaman;
use App\Models\Rak;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArchiveStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Dalam implementasi nyata, data ini akan diambil dari database
        return [
            Stat::make('Total User', User::count())
                ->description('Total dokumen dalam sistem')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40]),
            Stat::make('Total Dokumen', Dokumen::count())
                ->description('Total dokumen dalam sistem')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40]),
            Stat::make('Total Peminjaman', Peminjaman::count())
                ->description('Total dokumen yang di pinjam dalam sistem')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40]),
            Stat::make('Total Rak', Rak::count())
                ->description('Total rak dalam sistem')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40]),
            
        ];
    }
}