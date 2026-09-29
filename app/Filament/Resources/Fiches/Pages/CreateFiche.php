<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFiche extends CreateRecord
{
    protected static string $resource = FicheResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Fiche créée avec succès';
    }
}
