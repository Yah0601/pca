<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('prenom')
                    ->required(),
                TextInput::make('nom')
                    ->required(),
                TextInput::make('login')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->placeholder('Sélectionnez')
                    ->options([
                        'Superviseur' => 'Superviseur',
                        'Chef de production' => 'Chef de production',
                        'RO' => 'RO',
                        'Super Admin' => 'Super Admin',
                        // '7400'  => '7400',
                        // '37070' => '37070',
                        // '7414'  => '7414',
                        // '37171' => '37171',
                    ])
                    ->required(),
                // TextInput::make('role')
                //     ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->default('TCC@2026'),
            ]);
    }
}




// 'Superviseur',
//         'Chef de production',
//         'RO',
//         'Super Admin',
