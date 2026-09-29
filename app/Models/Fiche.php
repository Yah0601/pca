<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fiche extends Model
{
    protected $fillable = [
        'titre',
        'motif_id',
        'sujet',
        'categorie',
        'numero_appelant',
        'lignes_client',
        'service',
        'numero_appele',
        'description',
        'commentaire_solution',
        'statut',
        'groupe_traitement',
        'user_id',
        'origine',
        'site',
        'offre',
    ];

    protected static function booted(): void
    {
        static::saving(function (Fiche $fiche) {

            /*
             * MOTIF → SUJET + CATÉGORIE + TITRE
             */
            if ($fiche->motif_id) {
                $motif = Motif::find($fiche->motif_id);

                if ($motif) {
                    $fiche->sujet = $motif->sujet;
                    $fiche->categorie = $motif->categorie;

                    $fiche->titre =
                        $motif->sujet . ' | ' .
                        $motif->categorie . ' | ' .
                        $motif->motif;
                }
            }

            /*
             * SERVICE → NUMÉRO APPELÉ
             */
            $fiche->numero_appele = match ((string) $fiche->service) {
                '7400' => '60000',
                '37070' => '60008',
                '7414' => '7414',
                '37171' => '60020',
                default => null,
            };

            /*
             * COMMENTAIRE → STATUT + GROUPE DE TRAITEMENT
             */
            if (filled($fiche->commentaire_solution)) {
                $fiche->statut = 'Clôturé';
                $fiche->groupe_traitement = 'PlateauTCC';
            } else {
                $fiche->statut = 'Actif';
                $fiche->groupe_traitement = 'BO TCC';
            }

            /*
             * UTILISATEUR CONNECTÉ
             */
            if (! $fiche->user_id && auth()->check()) {
                $fiche->user_id = auth()->id();
            }
        });
    }

    public function motif(): BelongsTo
    {
        return $this->belongsTo(Motif::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
