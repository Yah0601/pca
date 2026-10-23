<?php

namespace App\Filament\Concerns;

use Filament\Actions\Action;

trait HasRetourAction
{
    protected function retourAction(): Action
    {
        return Action::make('retour')
            ->label('Retour')
            ->icon('heroicon-m-arrow-left')
            ->color('gray')
            ->url(url('/'));
    }
}
