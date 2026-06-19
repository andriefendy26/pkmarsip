<?php

namespace App\Filament\Resources\Klasters\Pages;

use App\Filament\Resources\Klasters\KlasterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKlaster extends EditRecord
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
