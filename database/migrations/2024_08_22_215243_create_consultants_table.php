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
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('telephone');
            $table->string('adresse');
            $table->string('competences');
            $table->string('experiences');
            $table->string('status');
            $table->date('date_disponibilite');
            $table->string('statut_evaluation');
            $table->date('date_de_naissance');
            $table->string('notes_mission')->nullable();
            $table->string('commentaires')->nullable();
            $table->string('cv');
            $table->foreignIdFor(\App\Models\User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
