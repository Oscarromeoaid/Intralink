<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Vérifier si les colonnes existent avant de les ajouter
        if (!Schema::hasColumn('users', 'job_title')) {
            $table->string('job_title')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'location')) {
            $table->string('location')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'bio')) {
            $table->text('bio')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'avatar_path')) {
            $table->string('avatar_path')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'position_id')) {
            $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();
        }
        
        if (!Schema::hasColumn('users', 'departement_id')) {
            $table->foreignId('departement_id')->nullable()->constrained()->nullOnDelete();
        }
        
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('user');
        }
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'job_title','phone','location','bio'
            ]);
        });
    }
};
