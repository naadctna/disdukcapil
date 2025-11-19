<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== CEK SEMUA DATA YANG BERMASALAH ===\n\n";
    
    // Check all tables
    $tables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    
    foreach ($tables as $table) {
        echo "--- Checking table: $table ---\n";
        
        try {
            $count = DB::table($table)->count();
            echo "Total records: $count\n";
            
            if ($count > 0) {
                $records = DB::table($table)->get();
                
                foreach ($records as $record) {
                    $problems = [];
                    
                    // Check untuk masalah umum
                    if (is_numeric($record->alamat_asal ?? '') && !empty($record->alamat_asal)) {
                        $problems[] = "alamat_asal berisi angka: '" . $record->alamat_asal . "'";
                    }
                    
                    if (is_numeric($record->nama_prop_asal ?? '') && !empty($record->nama_prop_asal)) {
                        $problems[] = "nama_prop_asal berisi angka: '" . $record->nama_prop_asal . "'";
                    }
                    
                    if (!is_numeric($record->no_prop_asal ?? '') && !empty($record->no_prop_asal)) {
                        $problems[] = "no_prop_asal berisi huruf: '" . $record->no_prop_asal . "'";
                    }
                    
                    if (is_numeric($record->nama_kab_asal ?? '') && !empty($record->nama_kab_asal)) {
                        $problems[] = "nama_kab_asal berisi angka: '" . $record->nama_kab_asal . "'";
                    }
                    
                    if (!is_numeric($record->no_kab_asal ?? '') && !empty($record->no_kab_asal) && $record->no_kab_asal !== 'NULL') {
                        $problems[] = "no_kab_asal berisi huruf: '" . $record->no_kab_asal . "'";
                    }
                    
                    if (!empty($problems)) {
                        echo "\n❌ RECORD BERMASALAH - ID: {$record->id}\n";
                        echo "Nama: " . ($record->nama_lengkap ?? $record->nama ?? 'N/A') . "\n";
                        foreach ($problems as $problem) {
                            echo "  - $problem\n";
                        }
                        
                        echo "Data lengkap:\n";
                        echo "  alamat_asal: '" . ($record->alamat_asal ?? 'NULL') . "'\n";
                        echo "  nama_prop_asal: '" . ($record->nama_prop_asal ?? 'NULL') . "'\n";
                        echo "  no_prop_asal: '" . ($record->no_prop_asal ?? 'NULL') . "'\n";
                        echo "  nama_kab_asal: '" . ($record->nama_kab_asal ?? 'NULL') . "'\n";
                        echo "  no_kab_asal: '" . ($record->no_kab_asal ?? 'NULL') . "'\n";
                        echo "  nama_kec_asal: '" . ($record->nama_kec_asal ?? 'NULL') . "'\n";
                        echo "  no_kec_asal: '" . ($record->no_kec_asal ?? 'NULL') . "'\n";
                        
                        // Show what would display with current logic
                        echo "\n  Current display would be: ";
                        $alamat_display = '';
                        if (!empty($record->alamat_asal) && !is_numeric($record->alamat_asal) && strlen(trim($record->alamat_asal)) > 2) {
                            $alamat_display = trim($record->alamat_asal);
                            if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                                $alamat_display .= ', ' . trim($record->nama_kec_asal);
                            } else if (!empty($record->nama_kab_asal) && !is_numeric($record->nama_kab_asal)) {
                                $alamat_display .= ', ' . trim($record->nama_kab_asal);
                            }
                        } else {
                            $alamat_parts = [];
                            if (!empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                                $alamat_parts[] = trim($record->nama_kel_asal);
                            }
                            if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                                $alamat_parts[] = trim($record->nama_kec_asal);
                            }
                            if (!empty($record->nama_kab_asal) && !is_numeric($record->nama_kab_asal)) {
                                $alamat_parts[] = trim($record->nama_kab_asal);
                            }
                            $alamat_display = !empty($alamat_parts) ? implode(', ', array_slice($alamat_parts, 0, 2)) : 'Alamat tidak tersedia';
                        }
                        echo "'" . $alamat_display . "'\n";
                        
                        echo "\n";
                    }
                }
                
                // Summary
                $problemRecords = 0;
                foreach ($records as $record) {
                    $hasProblems = false;
                    if (is_numeric($record->alamat_asal ?? '') && !empty($record->alamat_asal)) $hasProblems = true;
                    if (is_numeric($record->nama_prop_asal ?? '') && !empty($record->nama_prop_asal)) $hasProblems = true;
                    if (!is_numeric($record->no_prop_asal ?? '') && !empty($record->no_prop_asal)) $hasProblems = true;
                    if (is_numeric($record->nama_kab_asal ?? '') && !empty($record->nama_kab_asal)) $hasProblems = true;
                    if (!is_numeric($record->no_kab_asal ?? '') && !empty($record->no_kab_asal) && $record->no_kab_asal !== 'NULL') $hasProblems = true;
                    
                    if ($hasProblems) $problemRecords++;
                }
                
                if ($problemRecords == 0) {
                    echo "✅ Tidak ada masalah data di tabel $table\n";
                } else {
                    echo "❌ Ditemukan $problemRecords record bermasalah dari total $count\n";
                }
            }
            
        } catch (\Exception $e) {
            echo "⚠️ Tabel $table tidak ada atau error: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    echo "=== SOLUSI ===\n";
    echo "Jika ada data bermasalah:\n";
    echo "1. Data mungkin perlu diupload ulang dengan format yang benar\n";
    echo "2. Atau perbaiki mapping di ExcelUploadController\n";
    echo "3. Atau bersihkan/perbaiki data yang salah\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}