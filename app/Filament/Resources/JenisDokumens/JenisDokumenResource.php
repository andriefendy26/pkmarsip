<?php

namespace App\Filament\Resources\JenisDokumens;

use App\Filament\Resources\JenisDokumens\Pages\CreateJenisDokumen;
use App\Filament\Resources\JenisDokumens\Pages\EditJenisDokumen;
use App\Filament\Resources\JenisDokumens\Pages\ListJenisDokumens;
use App\Filament\Resources\JenisDokumens\Schemas\JenisDokumenForm;
use App\Filament\Resources\JenisDokumens\Tables\JenisDokumensTable;
use App\Models\JenisDokumen;
use BackedEnum;
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJenisDokumens::route('/'),
            'create' => CreateJenisDokumen::route('/create'),
            'edit' => EditJenisDokumen::route('/{record}/edit'),
        ];
    }
}
