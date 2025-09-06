<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->datetime('scheduled_at');
            $table->integer('duration'); // en minutes
            $table->string('meeting_url')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->integer('max_participants')->nullable();
            $table->boolean('is_recorded')->default(false);
            $table->string('recording_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_sessions');
    }
};