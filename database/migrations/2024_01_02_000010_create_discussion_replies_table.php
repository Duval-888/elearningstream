<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('discussion_replies')->onDelete('cascade');
            $table->longText('content');
            $table->integer('like_count')->default(0);
            $table->enum('status', ['published', 'pending', 'approved', 'rejected', 'reported', 'deleted'])->default('published');
            $table->boolean('is_solution')->default(false);
            $table->timestamps();
            
            $table->index(['discussion_id', 'created_at']);
            $table->index(['author_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_replies');
    }
};