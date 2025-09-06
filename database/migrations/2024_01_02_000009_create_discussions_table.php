<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->string('slug')->unique();
            $table->enum('status', ['open', 'closed', 'pinned', 'resolved', 'archived'])->default('open');
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('category_id')->constrained('forum_categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->integer('view_count')->default(0);
            $table->integer('reply_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->json('tags')->nullable();
            $table->timestamp('last_reply_at')->nullable();
            $table->timestamps();
            
            $table->index(['category_id', 'status']);
            $table->index(['author_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};