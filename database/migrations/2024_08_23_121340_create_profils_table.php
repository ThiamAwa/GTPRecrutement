<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            // Colonne 'id' - Identifiant unique auto-incrémenté pour chaque profil
            $table->id();

            // Colonne 'first_name' - Prénom du candidat (obligatoire)
            $table->string('first_name');

            // Colonne 'last_name' - Nom de famille du candidat (obligatoire)
            $table->string('last_name');

            // Colonne 'email' - Adresse email unique du candidat (obligatoire)
            $table->string('email')->unique();

            // Colonne 'phone_number' - Numéro de téléphone du candidat (optionnel)
            $table->string('phone_number')->nullable();

            // Colonne 'address' - Adresse physique du candidat (optionnel)
            $table->string('address')->nullable();

            // Colonne 'education' - Formation académique du candidat (optionnel)
            $table->text('education')->nullable();

            // Colonne 'experience' - Expériences professionnelles du candidat (optionnel)
            $table->text('experience')->nullable();

            // Colonne 'skills' - Compétences techniques et soft-skills du candidat (optionnel)
            $table->text('skills')->nullable();

            // Colonne 'linkedin_profile' - Lien vers le profil LinkedIn du candidat (optionnel)
            $table->string('linkedin_profile')->nullable();

            // Colonne 'status' - Statut du profil : 'active', 'inactive', 'hired', avec 'active' par défaut
            $table->enum('status', ['active', 'inactive', 'hired'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
