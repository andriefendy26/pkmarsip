<?php

namespace App\Filament\Resources\Raks\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RakForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_rak')
                    ->label('Kode Rak')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: R01, R02'),

                TextInput::make('nama_rak')
                    ->label('Nama Rak')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Contoh: Rak A1, Rak B2'),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->rows(2)
                    ->placeholder('Deskripsikan rak penyimpanan ini...'),
            ]);
    }
}
