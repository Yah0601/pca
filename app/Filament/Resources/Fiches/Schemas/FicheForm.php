<?php

namespace App\Filament\Resources\Fiches\Schemas;

use App\Models\Motif;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FicheForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                Select::make('motif_id')
                    ->label('Motif')
                    ->relationship('motif', 'motif')
                    ->placeholder('Sélectionnez un motif')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set) {
                        if (! $state) {
                            $set('sujet', null);
                            $set('categorie', null);

                            return;
                        }

                        $motif = Motif::find($state);

                        if ($motif) {
                            $set('sujet', $motif->sujet);
                            $set('categorie', $motif->categorie);
                        }
                    })
                    ->required(),

                TextInput::make('sujet')
                    ->label('Sujet')
                    ->placeholder('Auto')
                    ->prefixIcon(Heroicon::OutlinedLockClosed)
                    ->readOnly()
                    ->dehydrated()
                    ->required(),

                TextInput::make('categorie')
                    ->label('Catégorie')
                    ->placeholder('Auto')
                    ->prefixIcon(Heroicon::OutlinedLockClosed)
                    ->readOnly()
                    ->dehydrated()
                    ->required(),

                TextInput::make('numero_appelant')
                    ->label('Numéro appelant')
                    ->placeholder('Ex. 72973985')
                    ->prefixIcon(Heroicon::OutlinedPhone)
                    ->tel()
                    ->regex('/^\+?[0-9\s]+$/')
                    ->maxLength(20)
                    ->validationMessages([
                        'regex' => 'Chiffres uniquement.',
                    ]),

                TextInput::make('lignes_client')
                    ->label('Lignes du client')
                    ->placeholder('Ex. 72973985')
                    ->prefixIcon(Heroicon::OutlinedPhone)
                    ->tel()
                    ->regex('/^\+?[0-9\s]+$/')
                    ->maxLength(20)
                    ->validationMessages([
                        'regex' => 'Chiffres uniquement.',
                    ]),

                Select::make('service')
                    ->label('Service')
                    ->placeholder('Sélectionnez')
                    ->options([
                        '7400'  => '7400',
                        '37070' => '37070',
                        '7414'  => '7414',
                        '37171' => '37171',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Décrivez la demande…')
                    ->rows(2)
                    ->columnSpan(2),

                Textarea::make('commentaire_solution')
                    ->label('Commentaire de la solution')
                    ->placeholder('Solution apportée…')
                    ->rows(2)
                    ->columnSpan(1),
            ]);
    }
}
