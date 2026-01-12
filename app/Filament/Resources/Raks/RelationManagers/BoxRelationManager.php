<?php

namespace App\Filament\Resources\Raks\RelationManagers;

use App\Filament\Resources\Boxes\BoxResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class BoxRelationManager extends RelationManager
{
    protected static string $relationship = 'Box';

    // protected static ?string $relatedResource = BoxResource::class;

    public function form(Schema $schema): Schema 
    {
        return $schema
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('kode_box')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_box')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->column([
                // Tables\Columns\TextColumn::make('kode_box')->label('Kode Box')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('nama_box')->label('Nama Box')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('kode_box')->label('Kode'),
                Tables\Columns\TextColumn::make('nama_box')->label('Nama'),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ;
    }
}
