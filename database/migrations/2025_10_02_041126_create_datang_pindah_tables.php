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
        // Tabel Datang 2024
        Schema::create('datang2024', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->date('tanggal_datang');
            $table->timestamps();
        });

        // Tabel Datang 2025
        Schema::create('datang2025', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->date('tanggal_datang');
            $table->timestamps();
        });

        // Tabel Pindah 2024
        Schema::create('pindah2024', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat_asal');
            $table->text('alamat_tujuan');
            $table->date('tanggal_pindah');
            $table->timestamps();
        });

        // Tabel Pindah 2025
        Schema::create('pindah2025', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat_asal');
            $table->text('alamat_tujuan');
            $table->date('tanggal_pindah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datang2024');
        Schema::dropIfExists('datang2025');
        Schema::dropIfExists('pindah2024');
        Schema::dropIfExists('pindah2025');
    }
};
