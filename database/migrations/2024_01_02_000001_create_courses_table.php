<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('duration')->nullable(); // en minutes
            $table->enum('level', ['debutant', 'intermediaire', 'avance'])->default('debutant');
            $table->string('category');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_free')->default(true);
            $table->integer('max_students')->nullable();
            $table->json('requirements')->nullable(); // prérequis
            $table->json('what_you_learn')->nullable(); // ce que vous apprendrez
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};