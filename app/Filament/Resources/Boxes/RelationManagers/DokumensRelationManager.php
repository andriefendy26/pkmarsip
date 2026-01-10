<?php

namespace App\Filament\Resources\Boxes\RelationManagers;

use App\Filament\Resources\Dokumens\DokumenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DokumensRelationManager extends RelationManager
{
    protected static string $relationship = 'dokumens';

    protected static ?string $relatedResource = DokumenResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
