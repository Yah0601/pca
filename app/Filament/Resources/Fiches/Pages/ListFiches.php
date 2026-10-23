<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

class ListFiches extends ListRecords
{
    protected static string $resource = FicheResource::class;

     #[Url(as: 'mes_fiches')]
    public bool $mesFiches = false;

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        if ($this->mesFiches) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
