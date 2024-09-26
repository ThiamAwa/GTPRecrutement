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
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 500);
            $table->text('description');
            $table->string('competences', 500);
            $table->string('experience', 500);
            $table->string('lieu', 255);
            $table->string('type_contrat', 255);
            $table->date('date_debut');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
//            $table->foreignId('candidat_id')->constrained('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
