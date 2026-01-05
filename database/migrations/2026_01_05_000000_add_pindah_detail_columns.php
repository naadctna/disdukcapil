<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add missing columns to pindah tables
        $tables = ['pindah2024', 'pindah2025'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    // Check if columns don't exist before adding
                    if (!Schema::hasColumn($table, 'jenis_pindah')) {
                        $blueprint->string('jenis_pindah')->nullable()->after('tgl_pindah');
                    }
                    if (!Schema::hasColumn($table, 'klasifikasi_pindah_ket')) {
                        $blueprint->string('klasifikasi_pindah_ket')->nullable()->after('klasifikasi_pindah');
                    }
                    if (!Schema::hasColumn($table, 'alasan_pindah')) {
                        $blueprint->string('alasan_pindah')->nullable()->after('klasifikasi_pindah_ket');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['pindah2024', 'pindah2025'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    if (Schema::hasColumn($table, 'jenis_pindah')) {
                        $blueprint->dropColumn('jenis_pindah');
                    }
                    if (Schema::hasColumn($table, 'klasifikasi_pindah_ket')) {
                        $blueprint->dropColumn('klasifikasi_pindah_ket');
                    }
                    if (Schema::hasColumn($table, 'alasan_pindah')) {
                        $blueprint->dropColumn('alasan_pindah');
                    }
                });
            }
        }
    }
};
