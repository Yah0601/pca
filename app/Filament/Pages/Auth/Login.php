<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;

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

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): string | Htmlable | null{
      //return "Le client au coeur de nos actions";
         return new \Illuminate\Support\HtmlString('<strong style="color: #ff7F00; font-size: 24px;">Le client au c&oelig;ur de nos actions</strong>');
          // return new \Illuminate\Support\HtmlString(
        //'<span style="color: #ff7F00; class="text-xl font-bold text-primary-600 tracking-wide block mt-2 text-center">' .
         //   'Le client au c&oelig;ur de nos actions' .
       // '</span>'
   // );

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
