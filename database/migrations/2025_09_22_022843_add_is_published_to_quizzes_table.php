<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Si la table existe déjà, on ne la recrée pas
        if (Schema::hasTable('quizzes')) {
            // (optionnel) S’assurer que la colonne is_published existe
            if (!Schema::hasColumn('quizzes', 'is_published')) {
                Schema::table('quizzes', function (Blueprint $table) {
                    $table->boolean('is_published')->default(false);
                });
            }
            return;
        }

        // ✅ Création initiale (inclut directement is_published)
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
