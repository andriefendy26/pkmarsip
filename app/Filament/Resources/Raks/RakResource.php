<?php

namespace App\Filament\Resources\Raks;

use App\Filament\Resources\Raks\Pages\CreateRak;
use App\Filament\Resources\Raks\Pages\EditRak;
use App\Filament\Resources\Raks\Pages\ListRaks;
use App\Filament\Resources\Raks\Schemas\RakForm;
use App\Filament\Resources\Raks\Tables\RaksTable;
use App\Models\Rak;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RakResource extends Resource
{
    protected static ?string $model = Rak::class;

    protected static string | UnitEnum | null $navigationGroup = 'Fisik';

    protected static ?string $recordTitleAttribute = 'nama_rak';

    public static function form(Schema $schema): Schema
    {
        return RakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RaksTable::configure($table);
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
            'index' => ListRaks::route('/'),
            'create' => CreateRak::route('/create'),
            'edit' => EditRak::route('/{record}/edit'),
        ];
    }
}
