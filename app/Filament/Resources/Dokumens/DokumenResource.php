<?php

namespace App\Filament\Resources\Dokumens;

use App\Filament\Resources\Dokumens\Pages\CreateDokumen;
use App\Filament\Resources\Dokumens\Pages\EditDokumen;
use App\Filament\Resources\Dokumens\Pages\ListDokumens;
use App\Filament\Resources\Dokumens\Schemas\DokumenForm;
use App\Filament\Resources\Dokumens\Tables\DokumensTable;
use App\Models\Dokumen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

use UnitEnum;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static string | UnitEnum | null $navigationGroup = 'Arsip Dokumen';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Dokumen';

    
    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->where('user_id', auth()->id());
    // }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = Filament::auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('user_id', $user->getKey());
    }

    public static function form(Schema $schema): Schema
    {
        return DokumenForm::configure($schema);
    }   

    public static function table(Table $table): Table
    {
        return DokumensTable::configure($table);
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
            'index' => ListDokumens::route('/'),
            'create' => CreateDokumen::route('/create'),
            'edit' => EditDokumen::route('/{record}/edit'),
        ];
    }
}
