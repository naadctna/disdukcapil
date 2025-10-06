<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penduduk extends Model
{
    // Method untuk get rekapitulasi - optimized version
    public static function getRekapitulasi()
    {
        $datang2024 = DB::table('datang2024')->count();
        $datang2025 = DB::table('datang2025')->count();
        $pindah2024 = DB::table('pindah2024')->count();
        $pindah2025 = DB::table('pindah2025')->count();
        
        $total_datang = $datang2024 + $datang2025;
        $total_pindah = $pindah2024 + $pindah2025;
        $hasil_akhir = $total_datang - $total_pindah;

        return (object)[
            'datang2024' => $datang2024,
            'datang2025' => $datang2025,
            'pindah2024' => $pindah2024,
            'pindah2025' => $pindah2025,
            'total_datang' => $total_datang,
            'total_pindah' => $total_pindah,
            'hasil_akhir' => $hasil_akhir
        ];
    }

    // Method untuk get data per tabel dengan limit untuk performance
    public static function getDataByTable($table)
    {
        // Untuk database test, gunakan NIK atau kolom pertama sebagai order
        if ($table == 'datang2024' || $table == 'datang2025') {
            // Gunakan tanggal_datang untuk sorting jika ada
            return DB::table($table)
                     ->orderBy('tanggal_datang', 'desc')
                     ->limit(100)
                     ->get();
        } else {
            // Untuk tabel pindah, gunakan tanggal_pindah
            return DB::table($table)
                     ->orderBy('tanggal_pindah', 'desc') 
                     ->limit(100)
                     ->get();
        }
    }

    // Method untuk search berdasarkan nama
    public static function searchByName($table, $search)
    {
        $query = DB::table($table)
                   ->where('nama', 'LIKE', '%' . $search . '%');
        
        // Order berdasarkan jenis tabel
        if ($table == 'datang2024' || $table == 'datang2025') {
            $query->orderBy('tanggal_datang', 'desc');
        } else {
            $query->orderBy('tanggal_pindah', 'desc');
        }
        
        return $query->limit(100)->get();
    }

    // Method untuk insert data
    public static function insertData($table, $data)
    {
        return DB::table($table)->insert($data);
    }
}
