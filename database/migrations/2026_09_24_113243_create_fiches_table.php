<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fiches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('motif_id')
                ->constrained('motifs')
                ->restrictOnDelete();

            $table->string('titre');

            $table->string('sujet');
            $table->string('categorie');

            $table->string('numero_appelant')->nullable();
            $table->string('lignes_client')->nullable();
            $table->string('service')->nullable();
            $table->string('numero_appele')->nullable();

            $table->text('description')->nullable();

            $table->text('commentaire_solution')->nullable();

            $table->string('statut')->nullable();
            $table->string('groupe_traitement')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('origine')->default('Téléphone');

            $table->string('site')->default('TCC');

            $table->string('offre')->nullable();

            $table->string('raison_du_statut')->nullable();

            $table->string('file_initiale')->default('Plateau_TCC');

          //  Raison du statut	File initiale	Groupe de traitement de l'agent


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiches');
    }
};
