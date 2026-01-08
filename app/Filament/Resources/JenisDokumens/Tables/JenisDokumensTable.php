<?php

namespace App\Filament\Resources\JenisDokumens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\View\Components\TextComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JenisDokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama_jenis_dokumen'),
                TextColumn::make('deskripsi'),
                // TextColumn::make(''),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
