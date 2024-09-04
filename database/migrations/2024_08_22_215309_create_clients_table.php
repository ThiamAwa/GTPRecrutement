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
        Schema::create('clients', function (Blueprint $table) {

            // Colonne 'id' - Identifiant unique auto-incrémenté pour chaque client
            $table->id();

            // Colonne 'name' - Nom complet du client (obligatoire)
            $table->string('name');

            // Colonne 'email' - Adresse email unique du client (obligatoire)
            $table->string('email')->unique();

            // Colonne 'phone_number' - Numéro de téléphone du client (optionnel)
            $table->string('phone_number')->nullable();

            // Colonne 'address' - Adresse physique du client (optionnel)
            $table->string('address')->nullable();

            // Colonne 'company_name' - Nom de l'entreprise du client, s'il représente une entreprise (optionnel)
            $table->string('company_name')->nullable();

            // Colonne 'company_website' - Site web de l'entreprise du client (optionnel)
            $table->string('company_website')->nullable();

            // Colonne 'contact_person' - Nom de la personne de contact principale (optionnel)
            $table->string('contact_person')->nullable();

            // Colonne 'status' - Statut du client : 'active', 'inactive', 'suspended', avec 'active' par défaut
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
