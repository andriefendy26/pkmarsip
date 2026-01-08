<?php

namespace App\Filament\Resources\JenisDokumens\Pages;

use App\Filament\Resources\JenisDokumens\JenisDokumenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisDokumens extends ListRecords
{
    protected static string $resource = JenisDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
