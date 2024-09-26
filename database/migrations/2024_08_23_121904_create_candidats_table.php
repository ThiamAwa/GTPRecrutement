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
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('telephone');
            $table->string('adresse');
            $table->text('competences')->nullable();
            $table->text('experience')->nullable();
//            $table->foreignId('offre_id')->constrained('offres')->onDelete('cascade');
            $table->string('status');
            $table->date('date_de_candidature');
            $table->date('date_de_naissance');
            $table->string('cv');
            $table->string('lm');
            $table->foreignIdFor(\App\Models\User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
