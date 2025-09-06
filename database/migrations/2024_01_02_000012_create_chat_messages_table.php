<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reply_to_id')->nullable()->constrained('chat_messages')->onDelete('set null');
            $table->longText('content');
            $table->enum('type', ['text', 'image', 'file', 'system'])->default('text');
            $table->json('attachments')->nullable();
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
            
            $table->index(['chat_id', 'created_at']);
            $table->index(['author_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};