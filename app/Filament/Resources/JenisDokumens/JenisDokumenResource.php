<?php

namespace App\Filament\Resources\JenisDokumens;

use App\Filament\Resources\JenisDokumens\Pages\CreateJenisDokumen;
use App\Filament\Resources\JenisDokumens\Pages\EditJenisDokumen;
// use App\Filament\Resources\JenisDokumens\Pages\ListJenisDokumen;
use App\Filament\Resources\JenisDokumens\Pages\ListJenisDokumens;
use App\Filament\Resources\JenisDokumens\Pages\ViewJenisDokumen;
// use App\Filament\Resources\JenisDokumens\Pages\ViewJenisDokumens;
use App\Filament\Resources\JenisDokumens\Schemas\JenisDokumenForm;
use App\Filament\Resources\JenisDokumens\Tables\JenisDokumensTable;
use App\Models\JenisDokumen;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JenisDokumenResource extends Resource
{
    protected static ?string $model = JenisDokumen::class;

    protected static string | UnitEnum | null $navigationGroup = 'Arsip Dokumen';

    protected static ?string $recordTitleAttribute = 'nama_jenis_dokumen';

    public static function form(Schema $schema): Schema
    {
        return JenisDokumenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisDokumensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\DokumensRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJenisDokumens::route('/'),
            'create' => CreateJenisDokumen::route('/create'),
            'view' => ViewJenisDokumen::route('/{record}'),
            'edit' => EditJenisDokumen::route('/{record}/edit'),
        ];
    }
}
