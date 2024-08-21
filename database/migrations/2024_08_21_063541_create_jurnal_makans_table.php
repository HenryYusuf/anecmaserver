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
        Schema::create('jurnal_makan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->date('tanggal')->nullable();

            $table->integer('sarapan_karbohidrat')->nullable();
            $table->integer('sarapan_lauk_hewani')->nullable();
            $table->integer('sarapan_lauk_nabati')->nullable();
            $table->integer('sarapan_sayur')->nullable();
            $table->integer('sarapan_buah')->nullable();

            $table->integer('makan_siang_karbohidrat')->nullable();
            $table->integer('makan_siang_lauk_hewani')->nullable();
            $table->integer('makan_siang_lauk_nabati')->nullable();
            $table->integer('makan_siang_sayur')->nullable();
            $table->integer('makan_siang_buah')->nullable();

            $table->integer('makan_malam_karbohidrat')->nullable();
            $table->integer('makan_malam_lauk_hewani')->nullable();
            $table->integer('makan_malam_lauk_nabati')->nullable();
            $table->integer('makan_malam_sayur')->nullable();
            $table->integer('makan_malam_buah')->nullable();

            $table->float('total_kalori');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_makans');
    }
};
