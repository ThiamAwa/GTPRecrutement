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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom du manager
            $table->string('prenom'); // Prénom du manager
            $table->string('email')->unique(); // Email du manager, unique
            $table->string('telephone')->nullable(); // Numéro de téléphone du manager, optionnel
            $table->string('poste'); // Poste occupé par le manager
            $table->text('adresse')->nullable(); // Adresse du manager, optionnel
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
