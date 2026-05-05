<?php

namespace App\Filament\Resources\Ruangans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;

class RuangansForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('kode_ruangan')->label('Kode Ruangan')->required(),
                TextInput::make('nama_ruangan')->label('Nama Ruangan')->required(),
                TextArea::make('deskripsi')->label('Deskripsi'),
            ]);
    }
}
