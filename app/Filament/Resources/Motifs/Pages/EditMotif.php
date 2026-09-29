<?php

namespace App\Filament\Resources\Motifs\Pages;

use App\Filament\Resources\Motifs\MotifResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMotif extends EditRecord
{
    protected static string $resource = MotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
