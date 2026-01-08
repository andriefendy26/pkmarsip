<?php

namespace App\Filament\Resources\Raks\Pages;

use App\Filament\Resources\Raks\RakResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRak extends CreateRecord
{
    protected static string $resource = RakResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
