<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['video', 'document', 'link', 'quiz']);
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_free')->default(false); // aperçu gratuit
            $table->integer('duration')->nullable(); // pour les vidéos
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_materials');
    }
};