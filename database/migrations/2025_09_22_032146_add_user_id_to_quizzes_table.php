<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Sur SQLite, on évite NOT NULL + FK en alter; on met nullable
            if (!Schema::hasColumn('quizzes', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                // Si tu n'es PAS sur SQLite tu peux ajouter le FK :
                // $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'user_id')) {
                // Si tu avais ajouté une FK sur MySQL :
                // $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
