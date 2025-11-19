<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Test Fix untuk Data Tertukar ===\n\n";
    
    // Cari data yang alamat_asal-nya berisi angka pendek (kode)
    $problematicRecords = DB::table('datang2024')
        ->where('alamat_asal', 'LIKE', '%32%')
        ->orWhere('alamat_asal', '=', '32')
        ->limit(5)
        ->get();
    
    if ($problematicRecords->count() == 0) {
        // Coba cari dengan pattern lain
        $problematicRecords = DB::table('datang2024')
            ->whereRaw("LENGTH(alamat_asal) <= 3")
            ->limit(5)
            ->get();
    }
    
    if ($problematicRecords->count() == 0) {
        // Ambil record random untuk test
        $problematicRecords = DB::table('datang2024')->limit(3)->get();
        echo "Menggunakan sample data untuk test:\n\n";
    } else {
        echo "Testing dengan " . $problematicRecords->count() . " records bermasalah:\n\n";
    }
    
    foreach ($problematicRecords as $i => $record) {
        echo "--- Record " . ($i + 1) . ": {$record->nama_lengkap} ---\n";
        echo "Data mentah:\n";
        echo "  alamat_asal: '{$record->alamat_asal}'\n";
        echo "  nama_kec_asal: '{$record->nama_kec_asal}'\n";
        echo "  no_kec_asal: '{$record->no_kec_asal}'\n";
        echo "  nama_kel_asal: '{$record->nama_kel_asal}'\n";
        echo "  no_prop_asal: '{$record->no_prop_asal}'\n";
        
        // Terapkan logic baru
        $alamat_display = '';
        
        // Deteksi jika data tertukar/kacau (alamat_asal berisi kode angka)
        $isProblematic = is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3;
        
        echo "\nAnalisis:\n";
        echo "  Alamat bermasalah? " . ($isProblematic ? "YA" : "TIDAK") . "\n";
        
        if ($isProblematic) {
            echo "  Mencari alamat sebenarnya...\n";
            
            // Data tertukar! Cari alamat sebenarnya dari kolom yang tepat
            $alamat_parts = [];
            
            // nama_kec_asal sering berisi alamat sebenarnya dalam data kacau
            if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                $hasAlamatPattern = (
                    strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                    strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'CILETENG') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'CUKANG') !== false
                );
                
                if ($hasAlamatPattern) {
                    $alamat_parts[] = trim($record->nama_kec_asal);
                    echo "  ✅ Found alamat di nama_kec_asal: '{$record->nama_kec_asal}'\n";
                } else {
                    echo "  ❌ nama_kec_asal tidak mengandung pola alamat\n";
                }
            }
            
            // no_kec_asal sering berisi nama kecamatan/kelurahan dalam data kacau
            if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                $alamat_parts[] = trim($record->no_kec_asal);
                echo "  ✅ Added wilayah dari no_kec_asal: '{$record->no_kec_asal}'\n";
            }
            
            // Jika tidak ada alamat ditemukan, gunakan nama_kel_asal
            if (empty($alamat_parts) && !empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                $alamat_parts[] = trim($record->nama_kel_asal);
                echo "  ⚠️  Fallback: menggunakan nama_kel_asal: '{$record->nama_kel_asal}'\n";
                
                // Tambah context dari no_prop_asal yang berisi nama tempat
                if (!empty($record->no_prop_asal) && !is_numeric($record->no_prop_asal)) {
                    $alamat_parts[] = trim($record->no_prop_asal);
                    echo "  ✅ Added context dari no_prop_asal: '{$record->no_prop_asal}'\n";
                }
            }
            
            $alamat_display = !empty($alamat_parts) ? 
                implode(', ', array_slice($alamat_parts, 0, 2)) : 
                'Data alamat bermasalah';
                
            echo "  Komponen alamat ditemukan: " . count($alamat_parts) . "\n";
        } else {
            // Data normal
            $alamat_display = trim($record->alamat_asal);
            echo "  Menggunakan alamat_asal langsung: '{$alamat_display}'\n";
        }
        
        echo "\nHASIL:\n";
        echo "  SEBELUM: '{$record->alamat_asal}'\n";
        echo "  SESUDAH: '{$alamat_display}'\n";
        
        $isImproved = ($isProblematic && $alamat_display !== $record->alamat_asal && $alamat_display !== 'Data alamat bermasalah');
        echo "  STATUS: " . ($isImproved ? "✅ DIPERBAIKI!" : ($isProblematic ? "⚠️  MASIH BERMASALAH" : "✅ SUDAH OK")) . "\n\n";
    }
    
    echo "✅ Perbaikan selesai! Refresh halaman web untuk melihat hasilnya.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}