<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('media_path')->nullable()->after('content');
            $table->string('media_type')->nullable()->after('media_path'); // image|video
            $table->string('media_mime')->nullable()->after('media_type');
            $table->unsignedBigInteger('media_size')->nullable()->after('media_mime');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['media_path', 'media_type', 'media_mime', 'media_size']);
        });
    }
};
