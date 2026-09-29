<?php

namespace App\Filament\Resources\Motifs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MotifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('motif')
                    ->required(),
                TextInput::make('sujet')
                    ->required(),
                TextInput::make('categorie')
                    ->required(),
                Toggle::make('actif')
                    ->required(),
            ]);
    }
}
