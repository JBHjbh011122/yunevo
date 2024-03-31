<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('nom')->after('id');
            $table->string('prenom')->after('nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'nom')) {
            $table->dropColumn('nom');
        }
        if (Schema::hasColumn('users', 'prenom')) {
            $table->dropColumn('prenom');
        }
        $table->string('name')->nullable();
    });
}

};
