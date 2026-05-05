<?php

namespace App\Filament\Resources\Ruangans;

use App\Filament\Resources\Ruangans\Pages\CreateRuangans;
use App\Filament\Resources\Ruangans\Pages\EditRuangans;
use App\Filament\Resources\Ruangans\Pages\ListRuangans;
use App\Filament\Resources\Ruangans\Schemas\RuangansForm;
use App\Filament\Resources\Ruangans\Tables\RuangansTable;
use App\Models\Ruangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RuangansResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    protected static string | UnitEnum | null $navigationGroup = 'Fisik';
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Ruangan';
    protected static ?string $recordTitleAttribute = 'ruangans';

    public static function form(Schema $schema): Schema
    {
        return RuangansForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RuangansTable::configure($table);
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
            'index' => ListRuangans::route('/'),
            'create' => CreateRuangans::route('/create'),
            'edit' => EditRuangans::route('/{record}/edit'),
        ];
    }
}
