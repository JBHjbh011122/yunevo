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
        Schema::table('entraineurs', function (Blueprint $table) {
            $table->dropForeign(['entraineur_id']);
            $table->foreign('entraineur_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entraineurs', function (Blueprint $table) {
            // 首先，删除现有的外键约束
            $table->dropForeign(['entraineur_id']);

            // 然后，重新创建外键约束但不使用 onDelete('cascade')
            $table->foreign('entraineur_id')
                  ->references('id')->on('users');
        });
    }
};
