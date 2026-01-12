<?php

namespace App\Filament\Resources\Lokasis\RelationManagers;

// use App\Filament\Resources\Lokasis\LokasiResource;
use App\Filament\Resources\Raks\RakResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class RakRelationManager extends RelationManager
{
    protected static string $relationship = 'Rak';

    // protected static ?string $relatedResource = RakResource::class;
    public function form(Schema $schema): Schema 
    {
        return $schema
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('kode_rak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_rak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
