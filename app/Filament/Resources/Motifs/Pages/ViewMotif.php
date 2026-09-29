<?php

namespace App\Filament\Resources\Motifs\Pages;

use App\Filament\Resources\Motifs\MotifResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMotif extends ViewRecord
{
    protected static string $resource = MotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
