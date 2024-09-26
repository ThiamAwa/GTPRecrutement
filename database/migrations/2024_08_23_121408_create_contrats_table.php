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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string('type_contrat'); // Ex: CDD, CDI, Freelance, etc.
            $table->enum('statut', ['en_cours', 'terminé', 'annulé'])->default('en_cours'); // Statut du contrat
            $table->date('date_debut');
            $table->date('date_fin');

            // Relations
            $table->foreignIdFor(\App\Models\Consultant::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(\App\Models\Mission::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(\App\Models\Client::class)
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
