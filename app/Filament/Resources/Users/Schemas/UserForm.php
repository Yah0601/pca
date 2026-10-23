<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

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
                // TextInput::make('email')
                //     ->label('Email address')
                //     ->email(),
                    //->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->placeholder('Sélectionnez')
                    ->options([
                        'CC' => 'CC',
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
                Select::make('division')
                    ->label('Division')
                    ->options([
                        'TCC' => 'TCC',
                        'CM' => 'CM',
                        'HV' => 'HV',
                    ])
                    ->required(),
                // TextInput::make('role')
                //     ->required(),
                TextInput::make('password')
    ->label('Mot de passe')
    ->password()
    ->revealable()
    ->required(fn (string $operation): bool => $operation === 'create')
    ->dehydrated(fn (?string $state): bool => filled($state))
    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
    ->helperText(fn (string $operation): ?string => $operation === 'edit'
        ? 'Laissez vide pour conserver le mot de passe actuel.'
        : null),
            ]);
    }
}




// 'Superviseur',
//         'Chef de production',
//         'RO',
//         'Super Admin',
