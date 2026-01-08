<?php

namespace App\Filament\Resources\Lokasis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LokasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_lokasi')
                    ->label('Kode Lokasi')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: LT1, GD2'),

                TextInput::make('nama_lokasi')
                    ->label('Nama Lokasi')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Contoh: Lantai 1, Gedung Utama'),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->rows(2)   
                    ->placeholder('Deskripsikan lokasi penyimpanan ini...'),
            ]);
    }
}
