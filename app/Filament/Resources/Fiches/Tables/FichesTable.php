<?php

namespace App\Filament\Resources\Fiches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FichesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('motif.motif')
                    ->searchable(),
                TextColumn::make('titre')
                    ->searchable(),
                TextColumn::make('sujet')
                    ->searchable(),
                TextColumn::make('categorie')
                    ->searchable(),
                TextColumn::make('numero_appelant')
                    ->searchable(),
                TextColumn::make('lignes_client')
                    ->searchable(),
                TextColumn::make('service')
                    ->searchable(),
                TextColumn::make('numero_appele')
                    ->searchable(),
                TextColumn::make('statut')
                    ->searchable(),
                TextColumn::make('groupe_traitement')
                    ->searchable(),
                TextColumn::make('user.login')
                    ->label("Propriétaire")
                    ->searchable(),
                // TextColumn::make('origine')
                //     ->searchable(),
                TextColumn::make('site')
                    ->searchable(),
                // TextColumn::make('offre')
                //     ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
