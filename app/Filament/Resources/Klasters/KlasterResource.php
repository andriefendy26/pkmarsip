<?php

namespace App\Filament\Resources\Klasters;

use App\Filament\Resources\Klasters\Pages\CreateKlaster;
use App\Filament\Resources\Klasters\Pages\EditKlaster;
use App\Filament\Resources\Klasters\Pages\ListKlasters;
use App\Filament\Resources\Klasters\Schemas\KlasterForm;
use App\Filament\Resources\Klasters\Tables\KlastersTable;
use App\Models\Klaster;
// use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KlasterResource extends Resource
{
    protected static ?string $model = Klaster::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'User Management';

    protected static ?string $recordTitleAttribute = 'name_klaster';

    public static function form(Schema $schema): Schema
    {
        return KlasterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KlastersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKlasters::route('/'),
            'create' => CreateKlaster::route('/create'),
            'edit' => EditKlaster::route('/{record}/edit'),
        ];
    }
}
