<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;
use App\Services\DynamicTableService;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Test koneksi database dulu
            DB::connection()->getPdo();
            
            $dynamicTableService = new DynamicTableService();
            $availableYears = $dynamicTableService->getAvailableYears();
            
            // Default ke tahun sekarang jika tidak ada data
            if (empty($availableYears)) {
                $availableYears = [date('Y')];
            }
            
            $yearlyData = [];
            $total_datang = 0;
            $total_pindah = 0;
            
            // Get data untuk setiap tahun yang ada (dengan cache untuk performa)
            $total_datang = 0;
            $total_pindah = 0;
            $yearlyData = [];
            
            // Limit max 5 tahun untuk performa
            $limitedYears = array_slice($availableYears, -5, 5);
            
            foreach ($limitedYears as $year) {
                $datangCount = $dynamicTableService->getDataCountByYear('datang', $year);
                $pindahCount = $dynamicTableService->getDataCountByYear('pindah', $year);
                
                $yearlyData["datang{$year}"] = $datangCount;
                $yearlyData["pindah{$year}"] = $pindahCount;
                
                $total_datang += $datangCount;
                $total_pindah += $pindahCount;
            }
            
            $rekapitulasi = (object)array_merge([
                'total_datang' => $total_datang,
                'total_pindah' => $total_pindah,
                'hasil_akhir' => $total_datang - $total_pindah,
                'available_years' => $availableYears
            ], $yearlyData);
            
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
        $search = $request->get('search', '');
        $status = $request->get('status', ''); // datang/pindah
        $tahun = $request->get('tahun', '');   // tahun dinamis
        $bulan = $request->get('bulan', '');   // filter bulan
        
        $dynamicTableService = new DynamicTableService();
        $availableYears = $dynamicTableService->getAvailableYears();
        
        // Init arrays
        $allData = [];
        
        // Tentukan tahun yang akan diproses
        $yearsToProcess = $tahun ? [$tahun] : $availableYears;
        
        // Tentukan status yang akan diproses
        $statusesToProcess = $status ? [$status] : ['datang', 'pindah'];
        
        foreach ($yearsToProcess as $year) {
            foreach ($statusesToProcess as $dataType) {
                $tableName = $dataType . $year;
                
                if ($dynamicTableService->tableExists($dataType, $year)) {
                    $query = DB::table($tableName);
                    
                    // Apply search filter
                    if ($search) {
                        $query->where(function($q) use ($search) {
                            $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                              ->orWhere('nama', 'LIKE', "%{$search}%")
                              ->orWhere('nik', 'LIKE', "%{$search}%");
                        });
                    }
                    
                    // Apply month filter
                    if ($bulan) {
                        if ($dataType === 'datang') {
                            $query->where(function($q) use ($bulan) {
                                $q->whereRaw('MONTH(tgl_datang) = ?', [$bulan])
                                  ->orWhereRaw('MONTH(tanggal_datang) = ?', [$bulan]);
                            });
                        } else {
                            $query->whereRaw('MONTH(tanggal_pindah) = ?', [$bulan]);
                        }
                    }
                    
                    // Tambah limit dan order untuk performa
                    $data = $query->orderBy('created_at', 'desc')
                                 ->limit(500)
                                 ->get();
                    
                    // Add table source for proper routing
                    foreach ($data as &$record) {
                        $record->table_source = $tableName;
                        $record->data_type = $dataType;
                        $record->year = $year;
                    }
                    
                    $allData[$tableName] = $data;
                } else {
                    $allData[$tableName] = [];
                }
            }
        }
        
        // Maintain backward compatibility with old variable names
        $datang2024 = $allData['datang2024'] ?? [];
        $datang2025 = $allData['datang2025'] ?? [];
        $pindah2024 = $allData['pindah2024'] ?? [];
        $pindah2025 = $allData['pindah2025'] ?? [];
        
        // Calculate summary stats  
        $rekapitulasi = (object)[
            'total_datang' => count($datang2024) + count($datang2025),
            'total_pindah' => count($pindah2024) + count($pindah2025),
            'hasil_akhir' => (count($datang2024) + count($datang2025)) - (count($pindah2024) + count($pindah2025))
        ];
        
        // Debug logging
        \Log::info('Penduduk Controller Debug:', [
            'datang2024_count' => count($datang2024),
            'datang2025_count' => count($datang2025),
            'pindah2024_count' => count($pindah2024),
            'pindah2025_count' => count($pindah2025),
            'search' => $search,
            'status' => $status,
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
        
        // Merge all data into a single collection for the view
        $penduduk = collect([]);
        
        // Add datang records with type indicator (updated untuk kolom baru)
        foreach($datang2024 as $record) {
            $record->jenis_data = 'Datang 2024';
            $record->tanggal = $record->tgl_datang ?? $record->tanggal_datang ?? '-';
            $record->table_source = 'datang2024';
            // Mapping kolom baru ke tampilan
            $record->nama = $record->nama_lengkap ?? $record->nama ?? 'Nama tidak tersedia';
            
            // FIXED: Smart alamat mapping untuk menangani data tertukar dari upload Excel
            $alamat_display = '';
            
            // Deteksi jika data tertukar/kacau (alamat_asal berisi kode angka)
            if (is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3) {
                // Data tertukar! Cari alamat sebenarnya dari kolom yang tepat
                $alamat_parts = [];
                
                // nama_kec_asal sering berisi alamat sebenarnya dalam data kacau
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal) && 
                    (strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                     strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'CILETENG') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'CUKANG') !== false)) {
                    $alamat_parts[] = trim($record->nama_kec_asal);
                }
                
                // no_kec_asal sering berisi nama kecamatan/kelurahan dalam data kacau
                if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                    $alamat_parts[] = trim($record->no_kec_asal);
                }
                
                // Jika tidak ada alamat ditemukan, gunakan nama_kel_asal
                if (empty($alamat_parts) && !empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                    $alamat_parts[] = trim($record->nama_kel_asal);
                    // Tambah context dari no_prop_asal yang berisi nama tempat
                    if (!empty($record->no_prop_asal) && !is_numeric($record->no_prop_asal)) {
                        $alamat_parts[] = trim($record->no_prop_asal);
                    }
                }
                
                $alamat_display = !empty($alamat_parts) ? 
                    implode(', ', array_slice($alamat_parts, 0, 2)) : 
                    'Data alamat bermasalah';
            }
            // Data normal: alamat_asal berisi alamat sebenarnya
            else {
                $alamat_display = trim($record->alamat_asal);
                
                // Tambahkan info wilayah jika tersedia
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                    $alamat_display .= ', ' . trim($record->nama_kec_asal);
                } else if (!empty($record->nama_kab_asal) && !is_numeric($record->nama_kab_asal)) {
                    $alamat_display .= ', ' . trim($record->nama_kab_asal);
                }
            }
            
            $record->alamat = $alamat_display;
            
            $penduduk->push($record);
        }
        
        foreach($datang2025 as $record) {
            $record->jenis_data = 'Datang 2025';
            $record->tanggal = $record->tgl_datang ?? $record->tanggal_datang ?? '-';
            $record->table_source = 'datang2025';
            // Mapping kolom baru ke tampilan
            $record->nama = $record->nama_lengkap ?? $record->nama ?? 'Nama tidak tersedia';
            
            // FIXED: Smart alamat mapping untuk menangani data tertukar dari upload Excel
            $alamat_display = '';
            
            // Deteksi jika data tertukar/kacau (alamat_asal berisi kode angka)
            if (is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3) {
                // Data tertukar! Cari alamat sebenarnya dari kolom yang tepat
                $alamat_parts = [];
                
                // nama_kec_asal sering berisi alamat sebenarnya dalam data kacau
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal) && 
                    (strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                     strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'CILETENG') !== false ||
                     strpos(strtoupper($record->nama_kec_asal), 'CUKANG') !== false)) {
                    $alamat_parts[] = trim($record->nama_kec_asal);
                }
                
                // no_kec_asal sering berisi nama kecamatan/kelurahan dalam data kacau
                if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                    $alamat_parts[] = trim($record->no_kec_asal);
                }
                
                // Jika tidak ada alamat ditemukan, gunakan nama_kel_asal
                if (empty($alamat_parts) && !empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                    $alamat_parts[] = trim($record->nama_kel_asal);
                    // Tambah context dari no_prop_asal yang berisi nama tempat
                    if (!empty($record->no_prop_asal) && !is_numeric($record->no_prop_asal)) {
                        $alamat_parts[] = trim($record->no_prop_asal);
                    }
                }
                
                $alamat_display = !empty($alamat_parts) ? 
                    implode(', ', array_slice($alamat_parts, 0, 2)) : 
                    'Data alamat bermasalah';
            }
            // Data normal: alamat_asal berisi alamat sebenarnya
            else {
                $alamat_display = trim($record->alamat_asal);
                
                // Tambahkan info wilayah jika tersedia
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                    $alamat_display .= ', ' . trim($record->nama_kec_asal);
                } else if (!empty($record->nama_kab_asal) && !is_numeric($record->nama_kab_asal)) {
                    $alamat_display .= ', ' . trim($record->nama_kab_asal);
                }
            }
            
            $record->alamat = $alamat_display;
            
            $penduduk->push($record);
        }
        
        // Add pindah records with type indicator (updated untuk kolom baru)
        foreach($pindah2024 as $record) {
            $record->jenis_data = 'Pindah 2024';
            $record->tanggal = $record->tgl_datang ?? $record->tanggal_pindah ?? '-';
            $record->table_source = 'pindah2024';
            // Mapping kolom baru ke tampilan
            $record->nama = $record->nama_lengkap ?? $record->nama ?? 'Nama tidak tersedia';
            
            // Enhanced alamat display untuk pindah
            $alamat_asal_display = '';
            if (!empty($record->alamat_asal) && !is_numeric($record->alamat_asal) && strlen(trim($record->alamat_asal)) > 2) {
                $alamat_asal_display = trim($record->alamat_asal);
            } else if (!empty($record->nama_kec_asal)) {
                $alamat_asal_display = trim($record->nama_kec_asal);
            } else {
                $alamat_asal_display = '-';
            }
            
            $alamat_tujuan_display = '';
            if (!empty($record->alamat_tujuan) && !is_numeric($record->alamat_tujuan) && strlen(trim($record->alamat_tujuan)) > 2) {
                $alamat_tujuan_display = trim($record->alamat_tujuan);
            } else if (!empty($record->nama_kec_tujuan)) {
                $alamat_tujuan_display = trim($record->nama_kec_tujuan);
            } else {
                $alamat_tujuan_display = '-';
            }
            
            $record->alamat = $alamat_asal_display . ' → ' . $alamat_tujuan_display;
            $penduduk->push($record);
        }
        
        foreach($pindah2025 as $record) {
            $record->jenis_data = 'Pindah 2025';
            $record->tanggal = $record->tgl_datang ?? $record->tanggal_pindah ?? '-';
            $record->table_source = 'pindah2025';
            // Mapping kolom baru ke tampilan
            $record->nama = $record->nama_lengkap ?? $record->nama ?? 'Nama tidak tersedia';
            
            // Enhanced alamat display untuk pindah
            $alamat_asal_display = '';
            if (!empty($record->alamat_asal) && !is_numeric($record->alamat_asal) && strlen(trim($record->alamat_asal)) > 2) {
                $alamat_asal_display = trim($record->alamat_asal);
            } else if (!empty($record->nama_kec_asal)) {
                $alamat_asal_display = trim($record->nama_kec_asal);
            } else {
                $alamat_asal_display = '-';
            }
            
            $alamat_tujuan_display = '';
            if (!empty($record->alamat_tujuan) && !is_numeric($record->alamat_tujuan) && strlen(trim($record->alamat_tujuan)) > 2) {
                $alamat_tujuan_display = trim($record->alamat_tujuan);
            } else if (!empty($record->nama_kec_tujuan)) {
                $alamat_tujuan_display = trim($record->nama_kec_tujuan);
            } else {
                $alamat_tujuan_display = '-';
            }
            
            $record->alamat = $alamat_asal_display . ' → ' . $alamat_tujuan_display;
            $penduduk->push($record);
        }
        
        // Sort by date (most recent first)
        $penduduk = $penduduk->sortByDesc('tanggal');
        
        return view('penduduk', compact(
            'datang2024', 'datang2025', 'pindah2024', 'pindah2025', 
            'rekapitulasi', 'search', 'status', 'tahun', 'bulan'
        ));
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
    
    /**
     * Show detailed view of a record (all columns from Excel A-AC)
     */
    public function viewDetail($table, $id)
    {
        $record = Penduduk::getDetailRecord($table, $id);
        
        if (!$record) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        
        // Convert object to array for easier handling
        $data = (array) $record;
        
        // Define user-friendly field labels for all 29 columns from Excel
        $fieldLabels = [
            'id' => 'ID',
            'nik' => 'NIK',
            'no_kk' => 'No. KK',
            'nama_lengkap' => 'Nama Lengkap',
            'no_datang' => 'No. Datang',
            'tgl_datang' => 'Tanggal Datang',
            'tanggal_datang' => 'Tanggal Datang',
            'klasifikasi_pindah' => 'Klasifikasi Pindah',
            'no_prop_asal' => 'No. Provinsi Asal',
            'nama_prop_asal' => 'Nama Provinsi Asal',
            'no_kab_asal' => 'No. Kabupaten Asal',
            'nama_kab_asal' => 'Nama Kabupaten Asal',
            'no_kec_asal' => 'No. Kecamatan Asal',
            'nama_kec_asal' => 'Nama Kecamatan Asal',
            'no_kel_asal' => 'No. Kelurahan Asal',
            'nama_kel_asal' => 'Nama Kelurahan Asal',
            'alamat_asal' => 'Alamat Asal',
            'no_rt_asal' => 'No. RT Asal',
            'no_rw_asal' => 'No. RW Asal',
            'no_prop_tujuan' => 'No. Provinsi Tujuan',
            'nama_prop_tujuan' => 'Nama Provinsi Tujuan',
            'no_kab_tujuan' => 'No. Kabupaten Tujuan',
            'nama_kab_tujuan' => 'Nama Kabupaten Tujuan',
            'no_kec_tujuan' => 'No. Kecamatan Tujuan',
            'nama_kec_tujuan' => 'Nama Kecamatan Tujuan',
            'no_kel_tujuan' => 'No. Kelurahan Tujuan',
            'nama_kel_tujuan' => 'Nama Kelurahan Tujuan',
            'alamat_tujuan' => 'Alamat Tujuan',
            'no_rt_tujuan' => 'No. RT Tujuan',
            'no_rw_tujuan' => 'No. RW Tujuan',
            'kode' => 'Kode',
            'nama' => 'Nama (Legacy)',
            'alamat' => 'Alamat (Legacy)',
            'created_at' => 'Dibuat',
            'updated_at' => 'Diperbarui'
        ];
        
        // Return JSON for modal display with field labels
        return response()->json([
            'success' => true,
            'data' => $data,
            'fieldLabels' => $fieldLabels,
            'table' => $table
        ]);
    }
}
