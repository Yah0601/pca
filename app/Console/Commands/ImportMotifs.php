<?php

namespace App\Console\Commands;

use App\Models\Motif;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportMotifs extends Command
{
    protected $signature = 'motifs:import {file=storage/app/motifs.csv}';
    protected $description = 'Importe les motifs depuis un fichier CSV (sujet;categorie;motif)';

    public function handle(): int
    {
        $path = base_path($this->argument('file'));
        if (! is_file($path)) {
            $this->error("Fichier introuvable : {$path}");
            return self::FAILURE;
        }

        $handle = fopen($path, 'r');
        fgetcsv($handle, 0, ';'); // ignorer l'en-tête

        $created = $skipped = 0;

        DB::transaction(function () use ($handle, &$created, &$skipped) {
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                [$sujet, $categorie, $motif] = array_map('trim', $row + [null, null, null]);
                if (! $sujet || ! $categorie || ! $motif) {
                    $skipped++;
                    continue;
                }

                $m = Motif::firstOrCreate(
                    ['sujet' => $sujet, 'categorie' => $categorie, 'motif' => $motif],
                    ['actif' => true]
                );
                $m->wasRecentlyCreated ? $created++ : $skipped++;
            }
        });
        fclose($handle);

        $this->info("Créés : {$created} | Ignorés (déjà présents/incomplets) : {$skipped}");
        return self::SUCCESS;
    }
}
