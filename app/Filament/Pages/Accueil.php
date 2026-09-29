<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class Accueil extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.pages.accueil';

    protected static ?string $slug = '';

    public static function getNavigationLabel(): string
    {
        return 'Accueil';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return '';
    }

    public function getHeader(): ?View
    {
        return null;
    }
}
