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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('rating'); // Pour la note
            $table->string('collaboration'); // Pour le retour sur la collaboration
            $table->string('delais'); // Pour le retour sur les délais
            $table->string('commentaire')->nullable(); // Pour les commentaires supplémentaires
            $table->foreignIdFor(\App\Models\Mission::class);
            $table->foreignIdFor(\App\Models\Consultant::class);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
