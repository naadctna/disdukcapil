<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update datang2024 table
        Schema::table('datang2024', function (Blueprint $table) {
            if (!Schema::hasColumn('datang2024', 'nik')) {
                $table->string('nik')->nullable()->after('id');
            }
            if (!Schema::hasColumn('datang2024', 'no_kk')) {
                $table->string('no_kk')->nullable()->after('nik');
            }
            if (!Schema::hasColumn('datang2024', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('no_kk');
            }
            if (!Schema::hasColumn('datang2024', 'no_datang')) {
                $table->string('no_datang')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('datang2024', 'tgl_datang')) {
                $table->string('tgl_datang')->nullable()->after('no_datang');
            }
            if (!Schema::hasColumn('datang2024', 'klasifikasi_pindah')) {
                $table->string('klasifikasi_pindah')->nullable()->after('tgl_datang');
            }
            if (!Schema::hasColumn('datang2024', 'no_prop_asal')) {
                $table->string('no_prop_asal')->nullable()->after('klasifikasi_pindah');
            }
            if (!Schema::hasColumn('datang2024', 'nama_prop_asal')) {
                $table->string('nama_prop_asal')->nullable()->after('no_prop_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_kab_asal')) {
                $table->string('no_kab_asal')->nullable()->after('nama_prop_asal');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kab_asal')) {
                $table->string('nama_kab_asal')->nullable()->after('no_kab_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_kec_asal')) {
                $table->string('no_kec_asal')->nullable()->after('nama_kab_asal');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kec_asal')) {
                $table->string('nama_kec_asal')->nullable()->after('no_kec_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_kel_asal')) {
                $table->string('no_kel_asal')->nullable()->after('nama_kec_asal');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kel_asal')) {
                $table->string('nama_kel_asal')->nullable()->after('no_kel_asal');
            }
            if (!Schema::hasColumn('datang2024', 'alamat_asal')) {
                $table->text('alamat_asal')->nullable()->after('nama_kel_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_rt_asal')) {
                $table->string('no_rt_asal')->nullable()->after('alamat_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_rw_asal')) {
                $table->string('no_rw_asal')->nullable()->after('no_rt_asal');
            }
            if (!Schema::hasColumn('datang2024', 'no_prop_tujuan')) {
                $table->string('no_prop_tujuan')->nullable()->after('no_rw_asal');
            }
            if (!Schema::hasColumn('datang2024', 'nama_prop_tujuan')) {
                $table->string('nama_prop_tujuan')->nullable()->after('no_prop_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'no_kab_tujuan')) {
                $table->string('no_kab_tujuan')->nullable()->after('nama_prop_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kab_tujuan')) {
                $table->string('nama_kab_tujuan')->nullable()->after('no_kab_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'no_kec_tujuan')) {
                $table->string('no_kec_tujuan')->nullable()->after('nama_kab_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kec_tujuan')) {
                $table->string('nama_kec_tujuan')->nullable()->after('no_kec_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'no_kel_tujuan')) {
                $table->string('no_kel_tujuan')->nullable()->after('nama_kec_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'nama_kel_tujuan')) {
                $table->string('nama_kel_tujuan')->nullable()->after('no_kel_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'alamat_tujuan')) {
                $table->text('alamat_tujuan')->nullable()->after('nama_kel_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'no_rt_tujuan')) {
                $table->string('no_rt_tujuan')->nullable()->after('alamat_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'no_rw_tujuan')) {
                $table->string('no_rw_tujuan')->nullable()->after('no_rt_tujuan');
            }
            if (!Schema::hasColumn('datang2024', 'kode')) {
                $table->string('kode')->nullable()->after('no_rw_tujuan');
            }
        });

        // Update datang2025 table
        Schema::table('datang2025', function (Blueprint $table) {
            if (!Schema::hasColumn('datang2025', 'nik')) {
                $table->string('nik')->nullable()->after('id');
            }
            if (!Schema::hasColumn('datang2025', 'no_kk')) {
                $table->string('no_kk')->nullable()->after('nik');
            }
            if (!Schema::hasColumn('datang2025', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('no_kk');
            }
            if (!Schema::hasColumn('datang2025', 'no_datang')) {
                $table->string('no_datang')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('datang2025', 'tgl_datang')) {
                $table->string('tgl_datang')->nullable()->after('no_datang');
            }
            if (!Schema::hasColumn('datang2025', 'klasifikasi_pindah')) {
                $table->string('klasifikasi_pindah')->nullable()->after('tgl_datang');
            }
            if (!Schema::hasColumn('datang2025', 'no_prop_asal')) {
                $table->string('no_prop_asal')->nullable()->after('klasifikasi_pindah');
            }
            if (!Schema::hasColumn('datang2025', 'nama_prop_asal')) {
                $table->string('nama_prop_asal')->nullable()->after('no_prop_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_kab_asal')) {
                $table->string('no_kab_asal')->nullable()->after('nama_prop_asal');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kab_asal')) {
                $table->string('nama_kab_asal')->nullable()->after('no_kab_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_kec_asal')) {
                $table->string('no_kec_asal')->nullable()->after('nama_kab_asal');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kec_asal')) {
                $table->string('nama_kec_asal')->nullable()->after('no_kec_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_kel_asal')) {
                $table->string('no_kel_asal')->nullable()->after('nama_kec_asal');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kel_asal')) {
                $table->string('nama_kel_asal')->nullable()->after('no_kel_asal');
            }
            if (!Schema::hasColumn('datang2025', 'alamat_asal')) {
                $table->text('alamat_asal')->nullable()->after('nama_kel_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_rt_asal')) {
                $table->string('no_rt_asal')->nullable()->after('alamat_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_rw_asal')) {
                $table->string('no_rw_asal')->nullable()->after('no_rt_asal');
            }
            if (!Schema::hasColumn('datang2025', 'no_prop_tujuan')) {
                $table->string('no_prop_tujuan')->nullable()->after('no_rw_asal');
            }
            if (!Schema::hasColumn('datang2025', 'nama_prop_tujuan')) {
                $table->string('nama_prop_tujuan')->nullable()->after('no_prop_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'no_kab_tujuan')) {
                $table->string('no_kab_tujuan')->nullable()->after('nama_prop_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kab_tujuan')) {
                $table->string('nama_kab_tujuan')->nullable()->after('no_kab_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'no_kec_tujuan')) {
                $table->string('no_kec_tujuan')->nullable()->after('nama_kab_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kec_tujuan')) {
                $table->string('nama_kec_tujuan')->nullable()->after('no_kec_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'no_kel_tujuan')) {
                $table->string('no_kel_tujuan')->nullable()->after('nama_kec_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'nama_kel_tujuan')) {
                $table->string('nama_kel_tujuan')->nullable()->after('no_kel_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'alamat_tujuan')) {
                $table->text('alamat_tujuan')->nullable()->after('nama_kel_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'no_rt_tujuan')) {
                $table->string('no_rt_tujuan')->nullable()->after('alamat_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'no_rw_tujuan')) {
                $table->string('no_rw_tujuan')->nullable()->after('no_rt_tujuan');
            }
            if (!Schema::hasColumn('datang2025', 'kode')) {
                $table->string('kode')->nullable()->after('no_rw_tujuan');
            }
        });
    }

    public function down()
    {
        // Drop the added columns if needed
    }
};