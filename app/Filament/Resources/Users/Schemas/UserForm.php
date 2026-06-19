<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Livewire\Form;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                    // ->required(),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique(ignoreRecord: true),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password(),
                    // ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Roles')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Select::make('klaster_id')
                    ->relationship('klaster', 'nama_klaster')
                    ->label('Klaster')
                    ->preload()
                    ->searchable(),
            ]);
    }
}
