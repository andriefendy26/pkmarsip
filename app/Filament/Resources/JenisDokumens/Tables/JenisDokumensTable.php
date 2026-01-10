<?php

namespace App\Filament\Resources\JenisDokumens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\View\Components\TextComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class JenisDokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama_jenis_dokumen'),
                TextColumn::make('deskripsi'),
                TextColumn::make('priode_retensi')
                    ->label('Priode Retensi')
                    ->sortable(),
                TextColumn::make('tindakan')
                    ->label('Tindakan')
                    ->sortable(),
                ImageColumn::make('qr_code_path')
                    ->label('QR Code')
                    ->getStateUsing(fn ($record) => $record->qr_code_url)
                    ->height(50)
                    ->width(50)
                    ->circular(false),
                // TextColumn::make(''),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
