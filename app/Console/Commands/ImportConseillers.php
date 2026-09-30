<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportConseillers extends Command
{
    protected $signature = 'conseillers:import
        {file=storage/app/conseillers.csv : Chemin du CSV relatif à la racine du projet}
        {--password= : Mot de passe commun (sinon un mot de passe aléatoire est généré par utilisateur)}
        {--dry-run : Simule l\'import sans rien écrire}';

    protected $description = 'Importe les conseillers depuis un CSV (prenom;nom;login;telephone;email;role)';

    public function handle(): int
    {
        $path = base_path($this->argument('file'));
        if (! is_file($path)) {
            $this->error("Fichier introuvable : {$path}");
            return self::FAILURE;
        }

        $commonPassword = $this->option('password');
        $dryRun = (bool) $this->option('dry-run');

        $handle = fopen($path, 'r');
        fgetcsv($handle, 0, ';'); // en-tête

        $created = $updated = $skipped = 0;
        $generated = [];

        DB::beginTransaction();

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            [$prenom, $nom, $login, $telephone, $email, $role] = array_map('trim', $row + array_fill(0, 6, ''));

            if (! $prenom || ! $nom || ! $login || ! $email) {
                $skipped++;
                continue;
            }

            $user = User::where('login', $login)->orWhere('email', $email)->first();

            $data = compact('prenom', 'nom', 'login', 'telephone', 'email', 'role');

            if ($user) {
                $user->forceFill($data)->save(); // le mot de passe existant est conservé
                $updated++;
            } else {
                $plain = $commonPassword ?: \Illuminate\Support\Str::password(12, symbols: false);
                $user = new User();
                $user->forceFill($data + [
                    'password' => Hash::make($plain),
                    'email_verified_at' => now(),
                ])->save();
                $created++;
                if (! $commonPassword) {
                    $generated[] = [$login, $email, $plain];
                }
            }
        }
        fclose($handle);

        if ($dryRun) {
            DB::rollBack();
            $this->warn('Mode simulation : aucune donnée écrite.');
        } else {
            DB::commit();
        }

        $this->info("Créés : {$created} | Mis à jour : {$updated} | Ignorés : {$skipped}");

        if ($generated && ! $dryRun) {
            $out = storage_path('app/conseillers_mots_de_passe.csv');
            $fh = fopen($out, 'w');
            fputcsv($fh, ['login', 'email', 'mot_de_passe'], ';');
            foreach ($generated as $g) {
                fputcsv($fh, $g, ';');
            }
            fclose($fh);
            $this->warn("Mots de passe générés : {$out} (à transmettre puis supprimer)");
        }

        return self::SUCCESS;
    }
}
