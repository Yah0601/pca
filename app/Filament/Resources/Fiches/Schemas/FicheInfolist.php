<?php

namespace App\Filament\Resources\Fiches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FicheInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('motif.motif')
                    ->label('Motif'),
                TextEntry::make('titre'),
                TextEntry::make('sujet'),
                TextEntry::make('categorie'),
                TextEntry::make('numero_appelant')
                    ->placeholder('-'),
                TextEntry::make('lignes_client')
                    ->placeholder('-'),
                TextEntry::make('service')
                    ->placeholder('-'),
                TextEntry::make('numero_appele')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('commentaire_solution')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('statut')
                    ->placeholder('-'),
                TextEntry::make('groupe_traitement')
                    ->placeholder('-'),
                TextEntry::make('user.login')
                    ->label('Proprietaire')
                    ->placeholder('-'),
                TextEntry::make('origine'),
                TextEntry::make('site'),
                TextEntry::make('offre')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
