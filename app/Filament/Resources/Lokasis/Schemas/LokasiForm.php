<?php

namespace App\Filament\Resources\Lokasis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Ruangan;

class LokasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ruangan_id')
                    ->label('Ruangan')
                    ->options(Ruangan::pluck('nama_ruangan', 'id'))
                    ->createOptionForm([
                        TextInput::make('nama_ruangan')
                            ->label('Nama Ruangan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ruangan Arsip'),
                        TextInput::make('kode_ruangan')
                            ->label('Kode Ruangan')
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: RA01, RB02'),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Ruangan')
                            ->rows(2)
                            ->placeholder('Deskripsikan ruangan ini...'),
                    ])
                    ->searchable()
                    ->required(),
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
