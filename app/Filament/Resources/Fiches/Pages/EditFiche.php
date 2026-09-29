<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFiche extends EditRecord
{
    protected static string $resource = FicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
