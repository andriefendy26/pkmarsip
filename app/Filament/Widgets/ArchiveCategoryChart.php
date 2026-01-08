<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ArchiveCategoryChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public function getHeading(): string
    {
        return 'Distribusi Kategori Arsip';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [35, 25, 20, 15, 5],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Laporan Kesehatan', 'Data Pasien', 'Dokumen Administrasi', 'Surat Izin', 'Lainnya'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}