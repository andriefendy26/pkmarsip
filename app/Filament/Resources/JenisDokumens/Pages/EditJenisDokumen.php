<?php

namespace App\Filament\Resources\JenisDokumens\Pages;

use App\Filament\Resources\JenisDokumens\JenisDokumenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisDokumen extends EditRecord
{
    protected static string $resource = JenisDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
