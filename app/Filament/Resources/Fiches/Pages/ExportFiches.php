<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use App\Models\Fiche;
use App\Models\User;
use Filament\Resources\Pages\Page;

class ExportFiches extends Page
{
    protected static string $resource = FicheResource::class;

    protected static ?string $title = 'Exporter les fiches';

    protected static ?string $slug = 'exporter-les-fiches';

    protected string $view = 'filament.pages.export-fiches';

    public string $statut = '';

    public string $service = '';

    public string $site = '';

    public string $dateDebut = '';

    public string $dateFin = '';

    public static function getNavigationLabel(): string
    {
        return 'Exporter les fiches';
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return false;
    }

    public static function canAccess(array $parameters = []): bool
    {
        return in_array(auth()->user()?->role, [
            'Superviseur',
            'Chef de production',
            'RO',
            'Agent qualité',
            'CC',
            'Super Admin',
        ], true);
    }

    /**
     * Rôles qui voient les fiches de toutes les divisions.
     * Pour que tous les rôles ayant accès à l'export voient tout,
     * remplace le corps de la méthode par : return true;
     */
    protected function voitToutesLesDivisions(): bool
    {
        return in_array(auth()->user()?->role, [
            'Super Admin',
            'Chef de production',
            'RO',
        ], true);
    }

    protected function baseQuery()
    {
        $user = auth()->user();
        $query = Fiche::query();

        if (! $this->voitToutesLesDivisions()) {
            $query->where('division', $user->division);
        }

        return $query;
    }

    // public function getGroupes(): array
    // {
    //     $user = auth()->user();

    //     $divisions = $this->voitToutesLesDivisions()
    //         ? User::whereNotNull('division')
    //             ->where('division', '!=', '')
    //             ->distinct()
    //             ->orderBy('division')
    //             ->pluck('division')
    //             ->all()
    //         : [$user->division];

    //     $groupes = [];

    //     foreach ($divisions as $division) {
    //         $groupes[] = 'Plateau_' . $division;
    //         $groupes[] = 'BACKOFFICE_' . $division;
    //         $groupes[] = 'BACKOFFICE RESIDENTIEL ' . $division;
    //     }

    //     return $groupes;
    // }


    public function getSites(): array
{
    if ($this->voitToutesLesDivisions()) {
        return User::whereNotNull('division')
            ->where('division', '!=', '')
            ->distinct()
            ->orderBy('division')
            ->pluck('division')
            ->all();
    }

    return [auth()->user()->division];
}


    public function getServices(): array
    {
        return $this->baseQuery()
            ->whereNotNull('service')
            ->where('service', '!=', '')
            ->distinct()
            ->orderBy('service')
            ->pluck('service')
            ->all();
    }

    public function exporter()
    {
        $query = $this->baseQuery()
            ->with(['user', 'motif'])
            ->orderBy('id');

        if ($this->statut !== '') {
            $query->where('statut', $this->statut);
        }

        if ($this->service !== '') {
            $query->where('service', $this->service);
        }

        // if ($this->groupe !== '') {
        //     $query->where('groupe_traitement', $this->groupe);
        // }

        if ($this->site !== '') {
    $query->where('division', $this->site);
}

        if ($this->dateDebut !== '') {
            $query->whereDate('created_at', '>=', $this->dateDebut);
        }

        if ($this->dateFin !== '') {
            $query->whereDate('created_at', '<=', $this->dateFin);
        }

        $fiches = $query->get();

        $filename = 'export-fiches-' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($fiches) {

            $handle = fopen('php://output', 'w');

            // BOM UTF-8 pour Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
               // 'ID',
                'Titre',
                'Origine',
                'Offre',
                'Sujet',
                'Catégorie',
                'Motif',
                'Numéro appelant',
                'Lignes du client',
                'Service',
                'Numéro appelé',
                'Description',
                'Commentaire solution',
                'Statut',
                'Groupe de traitement',
                'Site',
                'Créée par',
                'Date de création',
            ], ';');

            foreach ($fiches as $fiche) {

                $createdBy = $fiche->user
                    ? trim(($fiche->user->prenom ?? '') . ' ' . ($fiche->user->nom ?? ''))
                    : '';

                fputcsv($handle, [
                    // $fiche->id,
                    $fiche->titre,
                    $fiche->origine,
                    $fiche->offre,
                    $fiche->sujet,
                    $fiche->categorie,
                    $fiche->motif?->motif ?? '',
                    $fiche->numero_appelant,
                    $fiche->lignes_client ?? '',
                    $fiche->service,
                    $fiche->numero_appele,
                    $fiche->description,
                    $fiche->commentaire_solution,
                    $fiche->statut,
                    $fiche->groupe_traitement,
                    $fiche->site,
                    $createdBy,
                    $fiche->created_at?->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}

// namespace App\Filament\Resources\Fiches\Pages;

// use App\Filament\Resources\Fiches\FicheResource;
// use App\Models\Fiche;
// use Filament\Resources\Pages\Page;

// class ExportFiches extends Page
// {
//     protected static string $resource = FicheResource::class;

//     protected static ?string $title = 'Exporter les fiches';

//     protected static ?string $slug = 'exporter-les-fiches';

//     protected string $view = 'filament.pages.export-fiches';

//     public string $statut = '';

//     public string $service = '';

//     public string $groupe = '';

//     public string $dateDebut = '';

//     public string $dateFin = '';

//     public static function getNavigationLabel(): string
//     {
//         return 'Exporter les fiches';
//     }

//     public static function shouldRegisterNavigation(array $parameters = []): bool
//     {
//         return false;
//     }

//    public static function canAccess(array $parameters = []): bool
// {
//     return in_array(auth()->user()?->role, [
//         'Superviseur',
//         'Chef de production',
//         'RO',
//         'Super Admin',
//     ], true);
// }

//     public function exporter()
// {
//     $user = auth()->user();

//     $query = $this->baseQuery()
//     ->with(['user', 'motif'])
//     ->orderBy('id');
//     // $query = Fiche::query()
//     //     ->with(['user', 'motif'])
//     //     ->orderBy('id');

//     // Limiter à la division de l'utilisateur, sauf Super Admin
//     // if ($user?->role !== 'Super Admin') {
//     //     $query->whereHas('user', fn ($q) => $q->where('division', $user->division));
//     // }

//     if($user?->role !== 'Super Admin'){
//         $query->where('division', $user->division);
//     }


//     if ($this->statut !== '') {
//         $query->where('statut', $this->statut);
//     }

//     if ($this->service !== '') {
//         $query->where('service', $this->service);
//     }

//     if ($this->groupe !== '') {
//         $query->where('groupe_traitement', $this->groupe);
//     }

//     if ($this->dateDebut !== '') {
//         $query->whereDate('created_at', '>=', $this->dateDebut);
//     }

//     if ($this->dateFin !== '') {
//         $query->whereDate('created_at', '<=', $this->dateFin);
//     }

//     $fiches = $query->get();

//     $filename = 'export-fiches-' . now()->format('Y-m-d_H-i-s') . '.csv';

//     return response()->streamDownload(function () use ($fiches) {

//         $handle = fopen('php://output', 'w');

//         // BOM UTF-8 pour Excel
//         fwrite($handle, "\xEF\xBB\xBF");

//         fputcsv($handle, [
//             'ID',
//             'Titre',
//             'Motif',
//             'Sujet',
//             'Catégorie',
//             'Numéro appelant',
//             'Lignes du client',
//             'Service',
//             'Numéro appelé',
//             'Description',
//             'Commentaire solution',
//             'Statut',
//             'Groupe de traitement',
//             'Origine',
//             'Site',
//             'Offre',
//             'Créée par',
//             'Date de création',
//         ], ';');

//         foreach ($fiches as $fiche) {

//             $createdBy = $fiche->user
//                 ? trim(($fiche->user->prenom ?? '') . ' ' . ($fiche->user->nom ?? ''))
//                 : '';

//             fputcsv($handle, [
//                 $fiche->id,
//                 $fiche->titre,
//                 $fiche->motif?->motif ?? '',
//                 $fiche->sujet,
//                 $fiche->categorie,
//                 $fiche->numero_appelant,
//                 $fiche->lignes_client ?? '',
//                 $fiche->service,
//                 $fiche->numero_appele,
//                 $fiche->description,
//                 $fiche->commentaire_solution,
//                 $fiche->statut,
//                 $fiche->groupe_traitement,
//                 $fiche->origine,
//                 $fiche->site,
//                 $fiche->offre,
//                 $createdBy,
//                 $fiche->created_at?->format('d/m/Y H:i'),
//             ], ';');
//         }

//         fclose($handle);

//     }, $filename, [
//         'Content-Type' => 'text/csv; charset=UTF-8',
//     ]);
// }


// protected function baseQuery()
// {
//     $user = auth()->user();
//     $query = Fiche::query();

//     if ($user?->role !== 'Super Admin') {
//         $query->where('division', $user->division);
//     }

//     return $query;
// }

// public function getGroupes(): array
// {
//     $user = auth()->user();

//     // Super Admin : toutes les divisions, les autres : la leur seulement
//     $divisions = $user?->role === 'Super Admin'
//         ? \App\Models\User::whereNotNull('division')
//             ->where('division', '!=', '')
//             ->distinct()
//             ->orderBy('division')
//             ->pluck('division')
//             ->all()
//         : [$user->division];

//     $groupes = [];

//     foreach ($divisions as $division) {
//         $groupes[] = 'Plateau_' . $division;
//         $groupes[] = 'BACKOFFICE_' . $division;
//         $groupes[] = 'BACKOFFICE RESIDENTIEL ' . $division;
//     }

//     return $groupes;
// }

// public function getServices(): array
// {
//     return $this->baseQuery()
//         ->whereNotNull('service')
//         ->where('service', '!=', '')
//         ->distinct()
//         ->orderBy('service')
//         ->pluck('service')
//         ->all();
// }


// }
