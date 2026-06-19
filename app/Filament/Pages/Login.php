<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;

class Login extends \Filament\Auth\Pages\Login
{


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->label('Username')
                    
                    ->required()
                    ->autofocus()
                    ->rule(function () {
                        return function ($attribute, $value, $fail) {
                            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $fail('Silakan login menggunakan username, bukan alamat email.');
                            }
                        };
                    })
                    ,
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

     public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $credentials = [
            'username' => $data['username'],
            'password' => $data['password'],
        ];

        // Pakai guard panel Filament (bukan Auth::attempt() / guard default Laravel)
        if (! Filament::auth()->attempt($credentials, $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'data.username' => 'Username atau password salah.',
            ]);
        }

 
        return app(LoginResponse::class);
    }
}