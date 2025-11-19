<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class DynamicTableService
{
    /**
     * Create table untuk tahun tertentu jika belum ada
     */
    public function ensureTableExists(string $dataType, string $year): string
    {
        $tableName = $dataType . $year;
        
        if (!Schema::hasTable($tableName)) {
            $this->createTable($tableName, $dataType);
        }
        
        return $tableName;
    }

    /**
     * Create tabel baru dengan struktur lengkap (29 kolom Excel)
     */
    private function createTable(string $tableName, string $dataType): void
    {
        Schema::create($tableName, function (Blueprint $table) use ($dataType) {
            // Basic columns
            $table->id();
            $table->timestamps();
            
            // Core identity columns
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('nama')->nullable(); // legacy
            
            // Basic info
            $table->string('jenis_kelamin', 1)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('hubungan_keluarga')->nullable();
            $table->string('kewarganegaraan')->nullable();
            
            if ($dataType === 'datang') {
                // Columns untuk data datang
                $table->string('no_datang')->nullable();
                $table->date('tgl_datang')->nullable();
                $table->date('tanggal_datang')->nullable(); // legacy
                $table->string('klasifikasi_pindah')->nullable();
                
                // Alamat asal
                $table->string('no_prop_asal')->nullable();
                $table->string('nama_prop_asal')->nullable();
                $table->string('no_kab_asal')->nullable();
                $table->string('nama_kab_asal')->nullable();
                $table->string('no_kec_asal')->nullable();
                $table->string('nama_kec_asal')->nullable();
                $table->string('no_kel_asal')->nullable();
                $table->string('nama_kel_asal')->nullable();
                $table->text('alamat_asal')->nullable();
                $table->string('no_rt_asal')->nullable();
                $table->string('no_rw_asal')->nullable();
                
                // Alamat tujuan (sekarang)
                $table->string('no_prop_tujuan')->nullable();
                $table->string('nama_prop_tujuan')->nullable();
                $table->string('no_kab_tujuan')->nullable();
                $table->string('nama_kab_tujuan')->nullable();
                $table->string('no_kec_tujuan')->nullable();
                $table->string('nama_kec_tujuan')->nullable();
                $table->string('no_kel_tujuan')->nullable();
                $table->string('nama_kel_tujuan')->nullable();
                $table->text('alamat_tujuan')->nullable();
                $table->text('alamat')->nullable(); // legacy
                $table->string('no_rt_tujuan')->nullable();
                $table->string('no_rw_tujuan')->nullable();
                
                $table->string('kode')->nullable();
                
            } else { // pindah
                // Core pindah columns
                $table->string('no_pindah')->nullable();
                $table->date('tgl_pindah')->nullable();
                $table->date('tanggal_pindah')->nullable(); // legacy
                $table->string('klasifikasi_pindah')->nullable();
                $table->string('klasifikasi_pindah_ket')->nullable();
                $table->string('alasan_pindah')->nullable();
                $table->string('jenis_pindah')->nullable();
                
                // Alamat asal - lengkap untuk 2025 format
                $table->string('no_prop_asal')->nullable();
                $table->string('nama_prop_asal')->nullable();
                $table->string('no_kab_asal')->nullable();
                $table->string('nama_kab_asal')->nullable();
                $table->string('no_kec_asal')->nullable();
                $table->string('nama_kec_asal')->nullable();
                $table->string('no_kel_asal')->nullable();
                $table->string('nama_kel_asal')->nullable();
                $table->text('alamat_asal')->nullable();
                $table->string('no_rt_asal')->nullable();
                $table->string('no_rw_asal')->nullable();
                
                // Alamat tujuan - lengkap untuk 2025 format
                $table->string('no_prop_tujuan')->nullable();
                $table->string('nama_prop_tujuan')->nullable();
                $table->string('no_kab_tujuan')->nullable();
                $table->string('nama_kab_tujuan')->nullable();
                $table->string('no_kec_tujuan')->nullable();
                $table->string('nama_kec_tujuan')->nullable();
                $table->string('no_kel_tujuan')->nullable();
                $table->string('nama_kel_tujuan')->nullable();
                $table->text('alamat_tujuan')->nullable();
                $table->string('no_rt_tujuan')->nullable();
                $table->string('no_rw_tujuan')->nullable();
                
                // Legacy columns for compatibility
                $table->text('alamat')->nullable(); // legacy
                $table->string('rt_asal')->nullable();
                $table->string('rw_asal')->nullable();
                $table->string('kelurahan_asal')->nullable();
                $table->string('kecamatan_asal')->nullable();
                $table->string('kabupaten_asal')->nullable();
                $table->string('provinsi_asal')->nullable();
                $table->string('rt_tujuan')->nullable();
                $table->string('rw_tujuan')->nullable();
                $table->string('kelurahan_tujuan')->nullable();
                $table->string('kecamatan_tujuan')->nullable();
                $table->string('kabupaten_tujuan')->nullable();
                $table->string('provinsi_tujuan')->nullable();
                $table->string('kode_pos_tujuan', 5)->nullable();

                // Additional pindah columns
                $table->string('jenis_kepindahan')->nullable();
                $table->string('status_kk_pindah')->nullable();
                $table->string('status_kk_tujuan')->nullable();
                $table->string('no_surat_pindah')->nullable();
                $table->date('tgl_surat_pindah')->nullable();
                $table->string('instansi_penerbit')->nullable();
                
                // KODE column for 2025 format
                $table->string('kode')->nullable();
            }            // Common additional fields
            $table->string('alasan_datang')->nullable();
            $table->string('jenis_migrasi')->nullable();
        });
        
        \Log::info("Created dynamic table: {$tableName}");
    }

    /**
     * Get available years from existing tables
     */
    public function getAvailableYears(): array
    {
        $tables = DB::select("SHOW TABLES");
        $dbName = config('database.connections.mysql.database');
        $tableColumn = "Tables_in_{$dbName}";
        
        $years = [];
        foreach ($tables as $table) {
            $tableName = $table->$tableColumn;
            
            // Extract year from datang{year} or pindah{year}
            if (preg_match('/^(datang|pindah)(\d{4})$/', $tableName, $matches)) {
                $years[] = (int)$matches[2];
            }
        }
        
        $years = array_unique($years);
        sort($years, SORT_NUMERIC);
        
        return $years;
    }

    /**
     * Get data count by year and type (optimized)
     */
    public function getDataCountByYear(string $dataType, int $year): int
    {
        $tableName = $dataType . $year;
        
        try {
            if (Schema::hasTable($tableName)) {
                // Use faster count query with timeout
                return DB::table($tableName)
                         ->selectRaw('COUNT(*) as total')
                         ->value('total') ?? 0;
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to count data for table {$tableName}: " . $e->getMessage());
            // Return estimate if exact count fails
            return 0;
        }
        
        return 0;
    }
    
    /**
     * Check if table exists for year and type
     */
    public function tableExists(string $dataType, int $year): bool
    {
        $tableName = $dataType . $year;
        return Schema::hasTable($tableName);
    }
}