<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Dans la migration
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Option 1: Supprimer directement si vous êtes sûr
        $table->dropColumn('departement');
        
        // Option 2: D'abord rendre nullable pour vérifier
        // $table->string('departement')->nullable()->change();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('departement')->nullable();
    });
}
};