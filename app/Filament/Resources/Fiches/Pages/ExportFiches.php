<?php

namespace App\Filament\Resources\Fiches\Pages;

use App\Filament\Resources\Fiches\FicheResource;
use App\Models\Fiche;
use Filament\Resources\Pages\Page;

class ExportFiches extends Page
{
    protected static string $resource = FicheResource::class;

    protected static ?string $title = 'Exporter les fiches';

    protected static ?string $slug = 'exporter-les-fiches';

    protected string $view = 'filament.pages.export-fiches';

    public string $statut = '';

    public string $service = '';

    public string $groupe = '';

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
        'Super Admin',
    ], true);
}

    public function exporter()
    {
        $query = Fiche::query()
            ->with('user')
            ->orderBy('id');

        if ($this->statut !== '') {
            $query->where('statut', $this->statut);
        }

        if ($this->service !== '') {
            $query->where('service', $this->service);
        }

        if ($this->groupe !== '') {
            $query->where('groupe_traitement', $this->groupe);
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
                'ID',
                'Titre',
                'Motif',
                'Sujet',
                'Catégorie',
                'Numéro appelant',
                'Lignes du client',
                'Service',
                'Numéro appelé',
                'Description',
                'Commentaire solution',
                'Statut',
                'Groupe de traitement',
                'Origine',
                'Site',
                'Offre',
                'Créée par',
                'Date de création',
            ], ';');

            foreach ($fiches as $fiche) {

                $createdBy = $fiche->user
                    ? trim(($fiche->user->prenom ?? '') . ' ' . ($fiche->user->nom ?? ''))
                    : '';

                fputcsv($handle, [
                    $fiche->id,
                    $fiche->titre,
                    $fiche->motif?->motif ?? '',
                    $fiche->sujet,
                    $fiche->categorie,
                    $fiche->numero_appelant,
                    $fiche->lignes_client ?? '',
                    $fiche->service,
                    $fiche->numero_appele,
                    $fiche->description,
                    $fiche->commentaire_solution,
                    $fiche->statut,
                    $fiche->groupe_traitement,
                    $fiche->origine,
                    $fiche->site,
                    $fiche->offre,
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
