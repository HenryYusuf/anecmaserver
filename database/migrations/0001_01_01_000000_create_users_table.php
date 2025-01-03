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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Data Diri
            $table->string('name')->default('istri');
            $table->string('email')->unique();
            $table->date('usia')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('tempat_tinggal_ktp')->nullable();
            $table->string('tempat_tinggal_domisili')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            // Data Kehamilan
            $table->date('hari_pertama_haid')->nullable();
            $table->string('wilayah_binaan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('tempat_periksa_kehamilan')->nullable();
            // Data Suami
            $table->string('nama_suami')->nullable();
            $table->string('no_hp_suami')->nullable();
            $table->string('email_suami')->nullable();

            // Role
            $table->enum('role', ['admin', 'istri', 'suami', 'petugas'])->default('istri');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
