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
        Schema::create('entraineurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entraineur_id'); // 外键
            $table->string('categories_d_entraineur', 20);
            $table->string('description_d_entraineur', 500);
            $table->timestamps();

            $table->foreign('entraineur_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entraineurs');
    }
};
