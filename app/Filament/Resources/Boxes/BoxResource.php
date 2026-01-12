<?php

namespace App\Filament\Resources\Boxes;

use App\Filament\Resources\Boxes\Pages\CreateBox;
use App\Filament\Resources\Boxes\Pages\EditBox;
use App\Filament\Resources\Boxes\Pages\ListBoxes;
use App\Filament\Resources\Boxes\Pages\ViewBox;
use App\Filament\Resources\Boxes\RelationManagers\DokumensRelationManager;
use App\Filament\Resources\Boxes\Schemas\BoxForm;
use App\Filament\Resources\Boxes\Schemas\BoxInfolist;
use App\Filament\Resources\Boxes\Tables\BoxesTable;
use App\Models\Box;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BoxResource extends Resource
{
    protected static ?string $model = Box::class;
    
    // protected static ?string $navigationLabel = 'Boxes';
    protected static string | UnitEnum | null $navigationGroup = 'Fisik';

    protected static ?string $slug = 'boxes';

    protected static ?string $pluralModelLabel = 'Boxes';
    protected static ?string $navigationLabel = 'Boxes';
     protected static ?int $navigationSort = 3;


    protected static ?string $recordTitleAttribute = 'kode_box';

    public static function form(Schema $schema): Schema
    {
        return BoxForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BoxInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BoxesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            DokumensRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBoxes::route('/'),
            'create' => CreateBox::route('/create'),
            'view' => ViewBox::route('/{record}'),
            'edit' => EditBox::route('/{record}/edit'),
        ];
    }
}
