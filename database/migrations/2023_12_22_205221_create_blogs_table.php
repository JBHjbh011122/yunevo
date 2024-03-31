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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entraineur_id');
            $table->date('date_publication');
            $table->string('texte', 4000);
            $table->string('titre', 150);
            $table->string('lien_aws_photo_blog', 500);

            $table->foreign('entraineur_id')->references('entraineur_id')->on('entraineurs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
