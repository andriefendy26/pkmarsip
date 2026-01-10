<?php

namespace App\Filament\Resources\Retensis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RetensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('keterangan'),
                TextInput::make('priode_retensi'),
                TextInput::make('tindakan'),
                // Select::make('jenis_dokumen_id')
                //     ->option(JenisDokumen::pluck('nama_jenis_dokumen', 'id'))
                //     ->required()q
                //     ->numeric(),
                Select::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->relationship('jenisDokumen', 'nama_jenis_dokumen')
                    ->required()
                    ->searchable(),
            ]);
    }
}
