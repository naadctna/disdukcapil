<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Test koneksi database dulu
            DB::connection()->getPdo();
            
            // Query untuk data per tabel tahun
            $datang2024 = 0;
            $datang2025 = 0; 
            $pindah2024 = 0;
            $pindah2025 = 0;
            
            // Cek apakah tabel exists sebelum query
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
            
            $rekapitulasi = (object)[
                'total_datang' => $total_datang,
                'total_pindah' => $total_pindah,
                'hasil_akhir' => $total_datang - $total_pindah,
                'datang2024' => $datang2024,
                'datang2025' => $datang2025,
                'pindah2024' => $pindah2024,
                'pindah2025' => $pindah2025
            ];
            
            return view('dashboard', compact('rekapitulasi'));
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Dashboard error: ' . $e->getMessage());
            
            // Fallback jika ada error
            $rekapitulasi = (object)[
                'total_datang' => 0,
                'total_pindah' => 0,
                'hasil_akhir' => 0,
                'datang2024' => 0,
                'datang2025' => 0,
                'pindah2024' => 0,
                'pindah2025' => 0
            ];
            return view('dashboard', compact('rekapitulasi'));
        }
    }

    public function rekapitulasi()
    {
        $rekapitulasi = Penduduk::getRekapitulasi();
        return view('rekapitulasi', compact('rekapitulasi'));
    }

    public function penduduk(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            // Jika ada pencarian, filter berdasarkan nama
            $datang2024 = Penduduk::searchByName('datang2024', $search);
            $datang2025 = Penduduk::searchByName('datang2025', $search);
            $pindah2024 = Penduduk::searchByName('pindah2024', $search);
            $pindah2025 = Penduduk::searchByName('pindah2025', $search);
        } else {
            // Jika tidak ada pencarian, ambil data seperti biasa
            $datang2024 = Penduduk::getDataByTable('datang2024');
            $datang2025 = Penduduk::getDataByTable('datang2025');
            $pindah2024 = Penduduk::getDataByTable('pindah2024');
            $pindah2025 = Penduduk::getDataByTable('pindah2025');
        }
        
        // Debug logging
        \Log::info('Penduduk Controller Debug:', [
            'datang2024_count' => count($datang2024),
            'datang2025_count' => count($datang2025),
            'pindah2024_count' => count($pindah2024),
            'pindah2025_count' => count($pindah2025),
            'search' => $search
        ]);
        
        return view('penduduk', compact('datang2024', 'datang2025', 'pindah2024', 'pindah2025', 'search'));
    }

    public function updateData(Request $request, $table, $id)
    {
        try {
            // Validasi tabel yang diizinkan
            $allowedTables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
            if (!in_array($table, $allowedTables)) {
                return response()->json(['success' => false, 'message' => 'Tabel tidak valid'], 400);
            }

            // Ambil data lama untuk perbandingan
            $oldData = DB::table($table)->where('id', $id)->first();
            if (!$oldData) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }

            $data = [];
            $targetTable = $table; // Default target table sama dengan source table
            
            // Validasi dan prepare data berdasarkan jenis tabel
            if (str_contains($table, 'datang')) {
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'alamat' => 'required|string|max:255',
                    'tanggal_datang' => 'required|date'
                ]);
                
                // Tentukan tahun dari tanggal_datang
                $newYear = date('Y', strtotime($request->tanggal_datang));
                $targetTable = 'datang' . $newYear;
                
                // Validasi target table
                if (!in_array($targetTable, $allowedTables)) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Tahun ' . $newYear . ' tidak didukung. Gunakan tahun 2024 atau 2025.'
                    ], 400);
                }
                
                $data = [
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'tanggal_datang' => $request->tanggal_datang,
                    'created_at' => $oldData->created_at, // Pertahankan created_at asli
                    'updated_at' => now()
                ];
            } else {
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'alamat_asal' => 'required|string|max:255',
                    'alamat_tujuan' => 'required|string|max:255',
                    'tanggal_pindah' => 'required|date'
                ]);
                
                // Tentukan tahun dari tanggal_pindah
                $newYear = date('Y', strtotime($request->tanggal_pindah));
                $targetTable = 'pindah' . $newYear;
                
                // Validasi target table
                if (!in_array($targetTable, $allowedTables)) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Tahun ' . $newYear . ' tidak didukung. Gunakan tahun 2024 atau 2025.'
                    ], 400);
                }
                
                $data = [
                    'nama' => $request->nama,
                    'alamat_asal' => $request->alamat_asal,
                    'alamat_tujuan' => $request->alamat_tujuan,
                    'tanggal_pindah' => $request->tanggal_pindah,
                    'created_at' => $oldData->created_at, // Pertahankan created_at asli
                    'updated_at' => now()
                ];
            }

            // Jika target table sama dengan source table, lakukan update biasa
            if ($targetTable === $table) {
                $updated = DB::table($table)->where('id', $id)->update($data);
                
                if ($updated) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'Data berhasil diupdate!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Tidak ada perubahan data'
                    ]);
                }
            } else {
                // Jika target table berbeda, lakukan transfer data
                DB::beginTransaction();
                
                try {
                    // Insert data baru ke target table
                    $inserted = DB::table($targetTable)->insert($data);
                    
                    if ($inserted) {
                        // Hapus data lama dari source table
                        DB::table($table)->where('id', $id)->delete();
                        
                        DB::commit();
                        
                        return response()->json([
                            'success' => true, 
                            'message' => "Data berhasil dipindah dari {$table} ke {$targetTable}!"
                        ]);
                    } else {
                        DB::rollback();
                        return response()->json([
                            'success' => false, 
                            'message' => 'Gagal memindahkan data'
                        ], 500);
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Update data error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteData($table, $id)
    {
        try {
            // Validasi tabel yang diizinkan
            $allowedTables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
            if (!in_array($table, $allowedTables)) {
                return response()->json(['success' => false, 'message' => 'Tabel tidak valid'], 400);
            }

            // Cek apakah data exists
            $exists = DB::table($table)->where('id', $id)->exists();
            if (!$exists) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Delete data
            $deleted = DB::table($table)->where('id', $id)->delete();
            
            if ($deleted) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Data berhasil dihapus!'
                ]);
            } else {
                return response()->json([
                    'success' => false, 
                    'message' => 'Gagal menghapus data'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Delete data error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }
}
