<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->timestamps();
            
            $table->unique(['live_session_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_participants');
    }
};