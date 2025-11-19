<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penduduk extends Model
{
    protected $table = 'penduduk_data';
    protected $fillable = ['*'];

    // Method untuk get rekapitulasi - optimized version
    public static function getRekapitulasi()
    {
        // Query dari tabel yang benar-benar ada
        $datang2024 = 0;
        $datang2025 = 0;
        $pindah2024 = 0;
        $pindah2025 = 0;
        
        // Safe query dengan try-catch
        try {
            $datang2024 = DB::table('datang2024')->count();
        } catch (\Exception $e) {
            $datang2024 = 0;
        }
        
        try {
            $datang2025 = DB::table('datang2025')->count();
        } catch (\Exception $e) {
            $datang2025 = 0;
        }
        
        try {
            $pindah2024 = DB::table('pindah2024')->count();
        } catch (\Exception $e) {
            $pindah2024 = 0;
        }
        
        try {
            $pindah2025 = DB::table('pindah2025')->count();
        } catch (\Exception $e) {
            $pindah2025 = 0;
        }
        
        $total_datang = $datang2024 + $datang2025;
        $total_pindah = $pindah2024 + $pindah2025;
        $hasil_akhir = $total_datang - $total_pindah;

        return (object)[
            'total_datang' => $total_datang,
            'total_pindah' => $total_pindah,
            'hasil_akhir' => $hasil_akhir,
            'datang2024' => $datang2024,
            'datang2025' => $datang2025,
            'pindah2024' => $pindah2024,
            'pindah2025' => $pindah2025
        ];
    }

    // Method untuk get data per tabel dengan limit untuk performance
    public static function getDataByTable($table)
    {
        // Untuk database test, gunakan kolom yang benar
        try {
            // Semua tabel menggunakan tgl_datang untuk sorting
            return DB::table($table)
                     ->orderBy('tgl_datang', 'desc')
                     ->limit(100)
                     ->get();
        } catch (\Exception $e) {
            // Jika tabel tidak ada atau query gagal, kembalikan collection kosong agar UI tidak crash
            \Log::error("Error in getDataByTable for table $table: " . $e->getMessage());
            return collect([]);
        }
    }

    // Method untuk search berdasarkan nama (updated untuk kolom baru)
    public static function searchByName($table, $search)
    {
        try {
            $query = DB::table($table)
                       ->where(function($q) use ($search) {
                           $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                             ->orWhere('nama', 'LIKE', '%' . $search . '%')  // Fallback ke kolom lama
                             ->orWhere('nik', 'LIKE', '%' . $search . '%');
                       });

            // Order berdasarkan tgl_datang (semua tabel menggunakan kolom yang sama)
            $query->orderBy('tgl_datang', 'desc');

            return $query->limit(100)->get();
    } catch (\Exception $e) {
            return collect([]);
        }
    }

    // Method untuk insert data
    public static function insertData($table, $data)
    {
        return DB::table($table)->insert($data);
    }
    
    /**
     * Get detailed record with all columns (A sampai AC dari Excel)
     */
    public static function getDetailRecord($table, $id)
    {
        try {
            return DB::table($table)->where('id', $id)->first();
        } catch (\Exception $e) {
            return null;
        }
    }
}
