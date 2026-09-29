<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motif extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'motif',
        'sujet',
        'categorie',
        'actif',
    ];

    /**
     * Les attributs à caster.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Obtenir les fiches liées à ce motif.
     */
    public function fiches(): HasMany
    {
        return $this->hasMany(Fiche::class);
    }
}
