<?php

namespace App\Filament\Resources\Raks\Pages;

use App\Filament\Resources\Raks\RakResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRaks extends ListRecords
{
    protected static string $resource = RakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
