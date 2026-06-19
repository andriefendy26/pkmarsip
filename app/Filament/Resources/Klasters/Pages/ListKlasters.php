<?php

namespace App\Filament\Resources\Klasters\Pages;

use App\Filament\Resources\Klasters\KlasterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKlasters extends ListRecords
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
