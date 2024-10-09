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
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();

            $table->string('judul')->nullable();
            $table->text('konten')->nullable();

            $table->text('thumbnail')->nullable();
            $table->text('thumbnail_public_id')->nullable();

            $table->enum('jenis', ['materi', 'video'])->nullable();

            $table->enum('kategori', ['pencegahan', 'edukasi'])->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edukasi');
    }
};
