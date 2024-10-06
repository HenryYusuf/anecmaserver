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

            $table->integer('usia_kehamilan')->nullable();

            $table->date('tanggal')->nullable();

            $table->double('sarapan_karbohidrat')->nullable();
            $table->double('sarapan_lauk_hewani')->nullable();
            $table->double('sarapan_lauk_nabati')->nullable();
            $table->double('sarapan_sayur')->nullable();
            $table->double('sarapan_buah')->nullable();

            $table->double('makan_siang_karbohidrat')->nullable();
            $table->double('makan_siang_lauk_hewani')->nullable();
            $table->double('makan_siang_lauk_nabati')->nullable();
            $table->double('makan_siang_sayur')->nullable();
            $table->double('makan_siang_buah')->nullable();

            $table->double('makan_malam_karbohidrat')->nullable();
            $table->double('makan_malam_lauk_hewani')->nullable();
            $table->double('makan_malam_lauk_nabati')->nullable();
            $table->double('makan_malam_sayur')->nullable();
            $table->double('makan_malam_buah')->nullable();

            $table->double('total_kalori_karbohidrat')->nullable();
            $table->double('total_kalori_lauk_hewani')->nullable();
            $table->double('total_kalori_lauk_nabati')->nullable();
            $table->double('total_kalori_sayur')->nullable();
            $table->double('total_kalori_buah')->nullable();

            $table->double('total_kalori')->nullable();

            $table->string('hasil_gizi')->nullable();

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
