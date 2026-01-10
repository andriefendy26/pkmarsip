<?php

namespace App\Filament\Resources\JenisDokumens\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class JenisDokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_jenis_dokumen')
                    ->label('Nama Jenis Dokumen')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->rows(3)
                    ->placeholder('Deskripsikan jenis dokumen ini...'),
                TextInput::make('priode_retensi')
                    ->label('Priode Retensi')
                    ->nullable(),

                TextInput::make('tindakan')
                    ->label('Tindakan')
                    ->nullable(),

                Textarea::make('keterangan')
                    ->label('Keterangan Retensi')
                    ->rows(2)
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}
