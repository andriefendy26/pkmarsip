<?php

namespace App\Filament\Resources\Peminjamen\Schemas;

use App\Models\Dokumen;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PeminjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
