<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasAvatar;

class User extends Authenticatable implements HasName, HasAvatar
{
    use HasFactory, Notifiable;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'login',
        'email',
        'role',
        'telephone',
        'password',
    ];

    /**
     * Les attributs masqués pour les tableaux.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à caster.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

//     public function getFilamentName(): string
// {
//     return "{$this->prenom} {$this->nom}";
// }

public function getFilamentName(): string
{
    return "{$this->prenom} {$this->nom}";
}

public function getFilamentAvatarUrl(): ?string
{
    return asset('images/avatar-default.svg');
}

    /**
     * Obtenir les fiches créées/gérées par cet utilisateur.
     */
    public function fiches(): HasMany
    {
        return $this->hasMany(Fiche::class);
    }
}
