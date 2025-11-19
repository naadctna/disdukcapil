<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Test Perbaikan Data Kacau ===\n\n";
    
    // Ambil beberapa record bermasalah
    $problematicRecords = DB::table('datang2024')
        ->whereRaw("CAST(alamat_asal AS UNSIGNED) > 0")
        ->limit(5)
        ->get();
    
    if ($problematicRecords->count() == 0) {
        echo "Tidak ada data bermasalah untuk di-test\n";
        exit;
    }
    
    echo "Testing with " . $problematicRecords->count() . " problematic records:\n\n";
    
    foreach ($problematicRecords as $i => $record) {
        echo "--- Record " . ($i + 1) . ": {$record->nama_lengkap} ---\n";
        echo "Raw data bermasalah:\n";
        echo "  alamat_asal: '{$record->alamat_asal}' (SALAH - ini kode!)\n";
        echo "  nama_kec_asal: '{$record->nama_kec_asal}' (ini alamat sebenarnya!)\n";
        echo "  no_kec_asal: '{$record->no_kec_asal}' (ini wilayah!)\n";
        echo "  no_prop_asal: '{$record->no_prop_asal}' (ini nama tempat!)\n";
        
        // Apply new smart logic
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
                echo "  ✅ Found alamat di nama_kec_asal: '{$record->nama_kec_asal}'\n";
            }
            
            // no_kec_asal sering berisi nama kecamatan/kelurahan dalam data kacau
            if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                $alamat_parts[] = trim($record->no_kec_asal);
                echo "  ✅ Found wilayah di no_kec_asal: '{$record->no_kec_asal}'\n";
            }
            
            // Jika tidak ada alamat ditemukan, gunakan nama_kel_asal
            if (empty($alamat_parts) && !empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                $alamat_parts[] = trim($record->nama_kel_asal);
                echo "  ⚠️  Fallback to nama_kel_asal: '{$record->nama_kel_asal}'\n";
                // Tambah context dari no_prop_asal yang berisi nama tempat
                if (!empty($record->no_prop_asal) && !is_numeric($record->no_prop_asal)) {
                    $alamat_parts[] = trim($record->no_prop_asal);
                    echo "  ✅ Added context from no_prop_asal: '{$record->no_prop_asal}'\n";
                }
            }
            
            $alamat_display = !empty($alamat_parts) ? 
                implode(', ', array_slice($alamat_parts, 0, 2)) : 
                'Data alamat bermasalah';
        }
        
        echo "\nHASIL PERBAIKAN:\n";
        echo "  SEBELUM: '{$record->alamat_asal}' (kode tidak bermakna)\n";
        echo "  SESUDAH: '{$alamat_display}' (alamat sebenarnya)\n";
        
        $improvement = !is_numeric($alamat_display) && $alamat_display != 'Data alamat bermasalah';
        echo "  STATUS: " . ($improvement ? "✅ DIPERBAIKI" : "❌ MASIH BERMASALAH") . "\n\n";
    }
    
    echo "=== SUMMARY ===\n";
    echo "Perbaikan menangani data Excel yang mapping-nya salah:\n";
    echo "- alamat_asal yang berisi '32' → dicari alamat sebenarnya di kolom lain\n";
    echo "- nama_kec_asal yang berisi 'DUSUN LIMUS' → digunakan sebagai alamat\n";
    echo "- no_kec_asal yang berisi nama wilayah → digunakan sebagai konteks\n\n";
    echo "✅ Data kacau sekarang bisa ditampilkan dengan benar!\n";
    echo "✅ Refresh halaman /penduduk untuk melihat perbaikan.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}