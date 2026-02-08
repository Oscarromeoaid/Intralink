<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajoute d'abord les colonnes sans contrainte
            $table->foreignId('departement_id')->nullable()->after('location');
            $table->foreignId('position_id')->nullable()->after('departement_id');
        });

        // Ajoute les contraintes de clé étrangère
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departement_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['departement_id', 'position_id']);
        });
    }
};