<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getLoginFormComponent(): TextInput
    {
        return TextInput::make('login')
            ->label('Login')
            ->required()
            ->autofocus()
            ->autocomplete();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'login' => $data['login'],
            'password' => $data['password'],
        ];
    }

    // public function getRedirectUrl(): string
    // {
    //     return \App\Filament\Pages\Accueil::getUrl();

    // }
}
