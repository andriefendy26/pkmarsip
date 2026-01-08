<?php

namespace App\Filament\Resources\Raks\Pages;

use App\Filament\Resources\Raks\RakResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRak extends EditRecord
{
    protected static string $resource = RakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
