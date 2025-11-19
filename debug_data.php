<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Debugging Data Aktual di Database ===\n\n";
    
    // Check semua data di datang2024
    $records = DB::table('datang2024')->get();
    
    if ($records->count() == 0) {
        echo "❌ Tidak ada data di datang2024\n";
        
        // Check datang2025
        $records = DB::table('datang2025')->get();
        if ($records->count() == 0) {
            echo "❌ Tidak ada data di datang2025 juga\n";
            exit;
        } else {
            echo "✅ Menggunakan data dari datang2025\n\n";
        }
    } else {
        echo "✅ Menggunakan data dari datang2024\n\n";
    }
    
    echo "=== ANALISIS DATA MENTAH ===\n";
    
    foreach ($records->take(3) as $i => $record) {
        echo "--- Record " . ($i + 1) . " ---\n";
        echo "ID: " . $record->id . "\n";
        echo "nama_lengkap: '" . ($record->nama_lengkap ?? 'NULL') . "'\n";
        echo "alamat_asal: '" . ($record->alamat_asal ?? 'NULL') . "'\n";
        echo "nama_prop_asal: '" . ($record->nama_prop_asal ?? 'NULL') . "'\n";
        echo "nama_kab_asal: '" . ($record->nama_kab_asal ?? 'NULL') . "'\n";
        echo "nama_kec_asal: '" . ($record->nama_kec_asal ?? 'NULL') . "'\n";
        echo "nama_kel_asal: '" . ($record->nama_kel_asal ?? 'NULL') . "'\n";
        echo "no_prop_asal: '" . ($record->no_prop_asal ?? 'NULL') . "'\n";
        echo "no_kab_asal: '" . ($record->no_kab_asal ?? 'NULL') . "'\n";
        echo "no_kec_asal: '" . ($record->no_kec_asal ?? 'NULL') . "'\n";
        echo "no_kel_asal: '" . ($record->no_kel_asal ?? 'NULL') . "'\n";
        
        // Show what current logic would produce
        echo "\n--- Current Logic Output ---\n";
        
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
        
        echo "Current alamat display: '" . $alamat_display . "'\n";
        
        // Analyze what's wrong
        echo "\n--- ANALISIS MASALAH ---\n";
        
        if (is_numeric($record->alamat_asal ?? '')) {
            echo "❌ MASALAH: alamat_asal berisi angka: '" . ($record->alamat_asal ?? '') . "'\n";
        }
        
        if (is_numeric($record->nama_prop_asal ?? '')) {
            echo "❌ MASALAH: nama_prop_asal berisi angka: '" . ($record->nama_prop_asal ?? '') . "'\n";
        }
        
        if (!is_numeric($record->no_prop_asal ?? '') && !empty($record->no_prop_asal)) {
            echo "❌ MASALAH: no_prop_asal berisi huruf: '" . ($record->no_prop_asal ?? '') . "'\n";
        }
        
        echo "\n";
    }
    
    echo "=== REKOMENDASI PERBAIKAN ===\n";
    echo "Berdasarkan analisis data:\n";
    echo "1. Periksa apakah data upload Excel sudah benar\n";
    echo "2. Pastikan mapping kolom saat upload sudah tepat\n";
    echo "3. Cek apakah ada data yang tertukar posisinya\n\n";
    
    // Show column structure
    echo "=== STRUKTUR TABEL ===\n";
    $columns = DB::select("SHOW COLUMNS FROM datang2024");
    foreach ($columns as $col) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}