<?php

namespace App\Filament\Resources\Pengembalians\Schemas;

use App\Models\Peminjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Ramsey\Collection\Set;

class PengembalianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('peminjaman_id')
                    ->label('Kode Peminjaman')
                    ->options(Peminjaman::pluck('kode_peminjaman', 'id'))
                    ->required(),
                DatePicker::make('tanggal_kembali')
                    ->required(),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->options(\App\Models\User::pluck('name', 'id'))
                    ->required(),
            ]);
    }
}
