<?php

namespace App\Filament\Resources\Boxes\Pages;

use App\Filament\Resources\Boxes\BoxResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBox extends EditRecord
{
    protected static string $resource = BoxResource::class;

       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
