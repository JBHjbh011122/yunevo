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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entraineur_id');
            $table->boolean('est_public');
            $table->string('description', 4000);
            $table->string('lien_aws', 150);
            $table->date('date_publication');
            $table->string('titre', 150);

            // 设置外键约束
            $table->foreign('entraineur_id')->references('id')->on('entraineurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
