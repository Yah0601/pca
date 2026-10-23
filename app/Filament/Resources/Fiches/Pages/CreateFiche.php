<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use Filament\Resources\Pages\CreateRecord;
    use App\Filament\Concerns\HasRetourAction;


class CreateFiche extends CreateRecord
{
    protected static string $resource = FicheResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Fiche créée avec succès';
    }


}


