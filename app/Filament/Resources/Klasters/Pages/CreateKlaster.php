<?php

namespace App\Filament\Resources\Klasters\Pages;

use App\Filament\Resources\Klasters\KlasterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKlaster extends CreateRecord
{
    protected static string $resource = KlasterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
