<?php

namespace App\Filament\Resources\JenisDokumens\Pages;

use App\Filament\Resources\JenisDokumens\JenisDokumenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJenisDokumen extends ViewRecord
{
    protected static string $resource = JenisDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
