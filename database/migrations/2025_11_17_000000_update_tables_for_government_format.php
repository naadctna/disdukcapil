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
        // Update existing tables to match government format
        
        // Drop existing simple tables
        Schema::dropIfExists('datang2024');
        Schema::dropIfExists('datang2025'); 
        Schema::dropIfExists('pindah2024');
        Schema::dropIfExists('pindah2025');

        // Create new comprehensive datang tables
        Schema::create('datang2024', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('no_datang')->nullable();
            $table->date('tgl_datang')->nullable();
            $table->string('klasifikasi_pindah')->nullable();
            $table->string('no_prop_asal', 2)->nullable();
            $table->string('nama_prop_asal')->nullable();
            $table->string('no_kab_asal', 4)->nullable();
            $table->string('nama_kab_asal')->nullable();
            $table->string('no_kec_asal', 7)->nullable();
            $table->string('nama_kec_asal')->nullable();
            $table->string('no_kel_asal', 10)->nullable();
            $table->string('nama_kel_asal')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('no_rt_asal', 3)->nullable();
            $table->string('no_rw_asal', 3)->nullable();
            $table->string('no_prop_tujuan', 2)->nullable();
            $table->string('nama_prop_tujuan')->nullable();
            $table->string('no_kab_tujuan', 4)->nullable();
            $table->string('nama_kab_tujuan')->nullable();
            $table->string('no_kec_tujuan', 7)->nullable();
            $table->string('nama_kec_tujuan')->nullable();
            $table->string('no_kel_tujuan', 10)->nullable();
            $table->string('nama_kel_tujuan')->nullable();
            $table->text('alamat_tujuan')->nullable();
            $table->string('no_rt_tujuan', 3)->nullable();
            $table->string('no_rw_tujuan', 3)->nullable();
            $table->string('kode')->nullable();
            $table->timestamps();
        });

        Schema::create('datang2025', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('no_datang')->nullable();
            $table->date('tgl_datang')->nullable();
            $table->string('klasifikasi_pindah')->nullable();
            $table->string('no_prop_asal', 2)->nullable();
            $table->string('nama_prop_asal')->nullable();
            $table->string('no_kab_asal', 4)->nullable();
            $table->string('nama_kab_asal')->nullable();
            $table->string('no_kec_asal', 7)->nullable();
            $table->string('nama_kec_asal')->nullable();
            $table->string('no_kel_asal', 10)->nullable();
            $table->string('nama_kel_asal')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('no_rt_asal', 3)->nullable();
            $table->string('no_rw_asal', 3)->nullable();
            $table->string('no_prop_tujuan', 2)->nullable();
            $table->string('nama_prop_tujuan')->nullable();
            $table->string('no_kab_tujuan', 4)->nullable();
            $table->string('nama_kab_tujuan')->nullable();
            $table->string('no_kec_tujuan', 7)->nullable();
            $table->string('nama_kec_tujuan')->nullable();
            $table->string('no_kel_tujuan', 10)->nullable();
            $table->string('nama_kel_tujuan')->nullable();
            $table->text('alamat_tujuan')->nullable();
            $table->string('no_rt_tujuan', 3)->nullable();
            $table->string('no_rw_tujuan', 3)->nullable();
            $table->string('kode')->nullable();
            $table->timestamps();
        });

        // Create similar structure for pindah tables
        Schema::create('pindah2024', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('no_pindah')->nullable();
            $table->date('tgl_pindah')->nullable();
            $table->string('klasifikasi_pindah')->nullable();
            $table->string('no_prop_asal', 2)->nullable();
            $table->string('nama_prop_asal')->nullable();
            $table->string('no_kab_asal', 4)->nullable();
            $table->string('nama_kab_asal')->nullable();
            $table->string('no_kec_asal', 7)->nullable();
            $table->string('nama_kec_asal')->nullable();
            $table->string('no_kel_asal', 10)->nullable();
            $table->string('nama_kel_asal')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('no_rt_asal', 3)->nullable();
            $table->string('no_rw_asal', 3)->nullable();
            $table->string('no_prop_tujuan', 2)->nullable();
            $table->string('nama_prop_tujuan')->nullable();
            $table->string('no_kab_tujuan', 4)->nullable();
            $table->string('nama_kab_tujuan')->nullable();
            $table->string('no_kec_tujuan', 7)->nullable();
            $table->string('nama_kec_tujuan')->nullable();
            $table->string('no_kel_tujuan', 10)->nullable();
            $table->string('nama_kel_tujuan')->nullable();
            $table->text('alamat_tujuan')->nullable();
            $table->string('no_rt_tujuan', 3)->nullable();
            $table->string('no_rw_tujuan', 3)->nullable();
            $table->string('kode')->nullable();
            $table->timestamps();
        });

        Schema::create('pindah2025', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('no_pindah')->nullable();
            $table->date('tgl_pindah')->nullable();
            $table->string('klasifikasi_pindah')->nullable();
            $table->string('no_prop_asal', 2)->nullable();
            $table->string('nama_prop_asal')->nullable();
            $table->string('no_kab_asal', 4)->nullable();
            $table->string('nama_kab_asal')->nullable();
            $table->string('no_kec_asal', 7)->nullable();
            $table->string('nama_kec_asal')->nullable();
            $table->string('no_kel_asal', 10)->nullable();
            $table->string('nama_kel_asal')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('no_rt_asal', 3)->nullable();
            $table->string('no_rw_asal', 3)->nullable();
            $table->string('no_prop_tujuan', 2)->nullable();
            $table->string('nama_prop_tujuan')->nullable();
            $table->string('no_kab_tujuan', 4)->nullable();
            $table->string('nama_kab_tujuan')->nullable();
            $table->string('no_kec_tujuan', 7)->nullable();
            $table->string('nama_kec_tujuan')->nullable();
            $table->string('no_kel_tujuan', 10)->nullable();
            $table->string('nama_kel_tujuan')->nullable();
            $table->text('alamat_tujuan')->nullable();
            $table->string('no_rt_tujuan', 3)->nullable();
            $table->string('no_rw_tujuan', 3)->nullable();
            $table->string('kode')->nullable();
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