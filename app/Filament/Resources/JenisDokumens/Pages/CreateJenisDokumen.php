<?php

namespace App\Filament\Resources\JenisDokumens\Pages;

use App\Filament\Resources\JenisDokumens\JenisDokumenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisDokumen extends CreateRecord
{
    protected static string $resource = JenisDokumenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
