<?php

namespace App\Filament\Resources\Boxes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BoxForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_box')
                    ->required(),
                TextInput::make('nama_box')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Select::make('rak_id')
                    ->options(\App\Models\Rak::pluck('nama_rak', 'id'))
                    ->required(),
            ]);
    }
}
