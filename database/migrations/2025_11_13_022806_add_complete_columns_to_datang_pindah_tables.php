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
        // Tambah kolom kompleks untuk tabel datang2024
        Schema::table('datang2024', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('id');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('jenis_kelamin', 1)->nullable()->after('nama'); // L/P
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->string('status_kawin')->nullable()->after('pekerjaan');
            $table->string('hubungan_keluarga')->nullable()->after('status_kawin');
            $table->string('kewarganegaraan')->nullable()->after('hubungan_keluarga');
            $table->string('rt')->nullable()->after('alamat');
            $table->string('rw')->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->string('kode_pos', 5)->nullable()->after('provinsi');
            $table->string('alamat_asal')->nullable()->after('kode_pos');
            $table->string('alasan_datang')->nullable()->after('alamat_asal');
            $table->string('jenis_migrasi')->nullable()->after('alasan_datang'); // Pindah/Datang Lahir/dll
            $table->string('no_surat_pindah')->nullable()->after('jenis_migrasi');
            $table->date('tgl_surat_pindah')->nullable()->after('no_surat_pindah');
            $table->string('instansi_penerbit')->nullable()->after('tgl_surat_pindah');
        });

        // Tambah kolom kompleks untuk tabel datang2025
        Schema::table('datang2025', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('id');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('jenis_kelamin', 1)->nullable()->after('nama');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->string('status_kawin')->nullable()->after('pekerjaan');
            $table->string('hubungan_keluarga')->nullable()->after('status_kawin');
            $table->string('kewarganegaraan')->nullable()->after('hubungan_keluarga');
            $table->string('rt')->nullable()->after('alamat');
            $table->string('rw')->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->string('kode_pos', 5)->nullable()->after('provinsi');
            $table->string('alamat_asal')->nullable()->after('kode_pos');
            $table->string('alasan_datang')->nullable()->after('alamat_asal');
            $table->string('jenis_migrasi')->nullable()->after('alasan_datang');
            $table->string('no_surat_pindah')->nullable()->after('jenis_migrasi');
            $table->date('tgl_surat_pindah')->nullable()->after('no_surat_pindah');
            $table->string('instansi_penerbit')->nullable()->after('tgl_surat_pindah');
        });

        // Tambah kolom kompleks untuk tabel pindah2024
        Schema::table('pindah2024', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('id');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('jenis_kelamin', 1)->nullable()->after('nama');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->string('status_kawin')->nullable()->after('pekerjaan');
            $table->string('hubungan_keluarga')->nullable()->after('status_kawin');
            $table->string('kewarganegaraan')->nullable()->after('hubungan_keluarga');
            $table->string('rt_asal')->nullable()->after('alamat_asal');
            $table->string('rw_asal')->nullable()->after('rt_asal');
            $table->string('kelurahan_asal')->nullable()->after('rw_asal');
            $table->string('kecamatan_asal')->nullable()->after('kelurahan_asal');
            $table->string('kabupaten_asal')->nullable()->after('kecamatan_asal');
            $table->string('provinsi_asal')->nullable()->after('kabupaten_asal');
            $table->string('rt_tujuan')->nullable()->after('alamat_tujuan');
            $table->string('rw_tujuan')->nullable()->after('rt_tujuan');
            $table->string('kelurahan_tujuan')->nullable()->after('rw_tujuan');
            $table->string('kecamatan_tujuan')->nullable()->after('kelurahan_tujuan');
            $table->string('kabupaten_tujuan')->nullable()->after('kecamatan_tujuan');
            $table->string('provinsi_tujuan')->nullable()->after('kabupaten_tujuan');
            $table->string('kode_pos_tujuan', 5)->nullable()->after('provinsi_tujuan');
            $table->string('alasan_pindah')->nullable()->after('kode_pos_tujuan');
            $table->string('jenis_kepindahan')->nullable()->after('alasan_pindah');
            $table->string('status_kk_pindah')->nullable()->after('jenis_kepindahan');
            $table->string('status_kk_tujuan')->nullable()->after('status_kk_pindah');
            $table->string('no_surat_pindah')->nullable()->after('status_kk_tujuan');
            $table->date('tgl_surat_pindah')->nullable()->after('no_surat_pindah');
            $table->string('instansi_penerbit')->nullable()->after('tgl_surat_pindah');
        });

        // Tambah kolom kompleks untuk tabel pindah2025
        Schema::table('pindah2025', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('id');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('jenis_kelamin', 1)->nullable()->after('nama');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->string('status_kawin')->nullable()->after('pekerjaan');
            $table->string('hubungan_keluarga')->nullable()->after('status_kawin');
            $table->string('kewarganegaraan')->nullable()->after('hubungan_keluarga');
            $table->string('rt_asal')->nullable()->after('alamat_asal');
            $table->string('rw_asal')->nullable()->after('rt_asal');
            $table->string('kelurahan_asal')->nullable()->after('rw_asal');
            $table->string('kecamatan_asal')->nullable()->after('kelurahan_asal');
            $table->string('kabupaten_asal')->nullable()->after('kecamatan_asal');
            $table->string('provinsi_asal')->nullable()->after('kabupaten_asal');
            $table->string('rt_tujuan')->nullable()->after('alamat_tujuan');
            $table->string('rw_tujuan')->nullable()->after('rt_tujuan');
            $table->string('kelurahan_tujuan')->nullable()->after('rw_tujuan');
            $table->string('kecamatan_tujuan')->nullable()->after('kelurahan_tujuan');
            $table->string('kabupaten_tujuan')->nullable()->after('kecamatan_tujuan');
            $table->string('provinsi_tujuan')->nullable()->after('kabupaten_tujuan');
            $table->string('kode_pos_tujuan', 5)->nullable()->after('provinsi_tujuan');
            $table->string('alasan_pindah')->nullable()->after('kode_pos_tujuan');
            $table->string('jenis_kepindahan')->nullable()->after('alasan_pindah');
            $table->string('status_kk_pindah')->nullable()->after('jenis_kepindahan');
            $table->string('status_kk_tujuan')->nullable()->after('status_kk_pindah');
            $table->string('no_surat_pindah')->nullable()->after('status_kk_tujuan');
            $table->date('tgl_surat_pindah')->nullable()->after('no_surat_pindah');
            $table->string('instansi_penerbit')->nullable()->after('tgl_surat_pindah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datang2024', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pendidikan', 
                'pekerjaan', 'status_kawin', 'hubungan_keluarga', 'kewarganegaraan', 'rt', 'rw', 'kelurahan', 
                'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'alamat_asal', 'alasan_datang', 
                'jenis_migrasi', 'no_surat_pindah', 'tgl_surat_pindah', 'instansi_penerbit'
            ]);
        });

        Schema::table('datang2025', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pendidikan', 
                'pekerjaan', 'status_kawin', 'hubungan_keluarga', 'kewarganegaraan', 'rt', 'rw', 'kelurahan', 
                'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'alamat_asal', 'alasan_datang', 
                'jenis_migrasi', 'no_surat_pindah', 'tgl_surat_pindah', 'instansi_penerbit'
            ]);
        });

        Schema::table('pindah2024', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pendidikan', 
                'pekerjaan', 'status_kawin', 'hubungan_keluarga', 'kewarganegaraan', 'rt_asal', 'rw_asal', 
                'kelurahan_asal', 'kecamatan_asal', 'kabupaten_asal', 'provinsi_asal', 'rt_tujuan', 'rw_tujuan', 
                'kelurahan_tujuan', 'kecamatan_tujuan', 'kabupaten_tujuan', 'provinsi_tujuan', 'kode_pos_tujuan', 
                'alasan_pindah', 'jenis_kepindahan', 'status_kk_pindah', 'status_kk_tujuan', 'no_surat_pindah', 
                'tgl_surat_pindah', 'instansi_penerbit'
            ]);
        });

        Schema::table('pindah2025', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pendidikan', 
                'pekerjaan', 'status_kawin', 'hubungan_keluarga', 'kewarganegaraan', 'rt_asal', 'rw_asal', 
                'kelurahan_asal', 'kecamatan_asal', 'kabupaten_asal', 'provinsi_asal', 'rt_tujuan', 'rw_tujuan', 
                'kelurahan_tujuan', 'kecamatan_tujuan', 'kabupaten_tujuan', 'provinsi_tujuan', 'kode_pos_tujuan', 
                'alasan_pindah', 'jenis_kepindahan', 'status_kk_pindah', 'status_kk_tujuan', 'no_surat_pindah', 
                'tgl_surat_pindah', 'instansi_penerbit'
            ]);
        });
    }
};
