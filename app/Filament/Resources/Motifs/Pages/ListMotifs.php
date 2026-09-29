<?php

namespace App\Filament\Resources\Motifs\Pages;

use App\Filament\Resources\Motifs\MotifResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMotifs extends ListRecords
{
    protected static string $resource = MotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
