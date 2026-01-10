<?php

namespace App\Filament\Resources\Peminjamen\Schemas;

use App\Models\Dokumen;
use App\Models\Peminjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;

class PeminjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->default(fn () => ("PMJ" . str_pad(Peminjaman::count() + 1, 3, '0', STR_PAD_LEFT)),),
                DatePicker::make('tanggal_pinjam')
                    ->required(),
                DatePicker::make('tanggal_kembali'),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                // TextInput::make('user_id')
                //     ->required()
                //     ->numeric(),
                Select::make('dokumen_id')
                    ->label('Dokumen')
                    ->options(Dokumen::pluck('judul', 'id'))
                    ->required()
                    ->searchable(),
            ]);
    }
}
