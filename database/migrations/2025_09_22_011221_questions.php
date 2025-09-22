<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adapte les colonnes si tu avais un schéma précis
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();

            // Exemple de colonnes (mets les tiennes si besoin)
            $table->string('title');              // ex : intitulé de la question
            $table->text('body')->nullable();     // ex : énoncé long (optionnel)
            $table->json('options')->nullable();  // ex : choix multiples (optionnel)
            $table->string('correct_answer')->nullable(); // ex : réponse (ou index)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
