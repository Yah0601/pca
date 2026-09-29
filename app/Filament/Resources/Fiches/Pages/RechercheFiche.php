<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use App\Models\Fiche;
use Filament\Resources\Pages\Page;

class RechercheFiche extends Page
{
    protected static string $resource = FicheResource::class;

    protected static ?string $title = 'Rechercher une fiche';

    protected static ?string $slug = 'rechercher-une-fiche';

    protected string $view = 'filament.pages.recherche-fiche';

    public string $recherche = '';

    public bool $rechercheEffectuee = false;

    public $resultats = [];

    public static function getNavigationLabel(): string
    {
        return 'Rechercher une fiche';
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
{
    return false;
}

    public function rechercher(): void
    {
        $this->validate([
            'recherche' => ['required', 'string', 'max:255'],
        ]);

        $valeur = trim($this->recherche);

        $query = Fiche::query();

        if (ctype_digit($valeur)) {
            $query->where(function ($query) use ($valeur) {
                $query
                    ->where('id', (int) $valeur)
                    ->orWhere('numero_appelant', $valeur);
            });
        } else {
            $query->where('numero_appelant', $valeur);
        }

        $this->resultats = $query
            ->latest('id')
            ->get();

        $this->rechercheEffectuee = true;
    }

    public function reinitialiser(): void
    {
        $this->reset([
            'recherche',
            'resultats',
            'rechercheEffectuee',
        ]);
    }
}
