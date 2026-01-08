<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArchiveStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Dalam implementasi nyata, data ini akan diambil dari database
        return [
            Stat::make('Total Arsip', '1,234')
                ->description('Total dokumen dalam sistem')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40]),

            Stat::make('Arsip Aktif', '987')
                ->description('Dokumen yang masih berlaku')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->chart([5, 8, 12, 15, 18, 20, 22, 24, 26, 28, 30, 32]),

            Stat::make('Menunggu Verifikasi', '45')
                ->description('Dokumen perlu diverifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]),

            Stat::make('Kadaluarsa', '12')
                ->description('Dokumen yang sudah kadaluarsa')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->chart([1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6]),
        ];
    }
}