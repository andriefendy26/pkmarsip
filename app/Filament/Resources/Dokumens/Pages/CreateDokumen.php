<?php

namespace App\Filament\Resources\Dokumens\Pages;

use App\Filament\Resources\Dokumens\DokumenResource;
use Filament\Resources\Pages\CreateRecord;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

class CreateDokumen extends CreateRecord
{
    protected static string $resource = DokumenResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_user'] = Auth::id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
