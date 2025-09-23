<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('videos', function (Blueprint $table) {
            if (!Schema::hasColumn('videos', 'mime_type')) {
                $table->string('mime_type')->nullable()->after('video_url');
            }
        });
    }
    public function down(): void {
        Schema::table('videos', function (Blueprint $table) {
            if (Schema::hasColumn('videos', 'mime_type')) {
                $table->dropColumn('mime_type');
            }
        });
    }
};