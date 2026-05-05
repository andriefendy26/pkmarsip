<?php

namespace App\Filament\Resources\Ruangans\Pages;

use App\Filament\Resources\Ruangans\RuangansResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRuangans extends CreateRecord
{
    protected static string $resource = RuangansResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }    
}
