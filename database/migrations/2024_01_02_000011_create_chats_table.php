<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', ['global', 'private', 'group', 'course'])->default('private');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('participants'); // Array of user IDs
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};