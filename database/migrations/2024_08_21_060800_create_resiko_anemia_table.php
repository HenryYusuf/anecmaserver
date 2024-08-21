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
        Schema::create('resiko_anemia', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->integer('usia_kehamilan')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->boolean('riwayat_anemia')->default(0);
            $table->integer('konsumsi_ttd_7hari')->nullable();
            $table->float('hasil_hb')->nullable();
            $table->enum('resiko', ['rendah', 'tinggi'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resiko_anemia');
    }
};
