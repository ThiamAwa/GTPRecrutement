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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->enum('status', ['en_attente', 'en_cours', 'terminee'])->default('en_attente');
            $table->string('type_profil_recherche');
            $table->string('competences_requises');
            $table->string('niveau_experience');
            $table->integer('duree')->nullable();
            $table->text('objectifs');
            $table->foreignIdFor(\App\Models\Consultant::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Client::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
