<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Cari data dengan nama MONA (dari debug sebelumnya)
    $record = DB::table('datang2024')->where('nama_lengkap', 'LIKE', '%MONA%')->first();
    
    if ($record) {
        echo "=== Test dengan Data Bermasalah Asli ===\n\n";
        echo "Record: {$record->nama_lengkap}\n";
        echo "Raw data:\n";
        echo "  alamat_asal: '{$record->alamat_asal}'\n";
        echo "  nama_kec_asal: '{$record->nama_kec_asal}'\n";
        echo "  no_kec_asal: '{$record->no_kec_asal}'\n";
        echo "  nama_kel_asal: '{$record->nama_kel_asal}'\n";
        
        // Test logic
        $isProblematic = is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3;
        
        echo "\nIs problematic? " . ($isProblematic ? "YES" : "NO") . "\n";
        
        if ($isProblematic) {
            $alamat_parts = [];
            
            // Check nama_kec_asal for address patterns
            if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                $hasPattern = (
                    strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                    strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                    strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false
                );
                
                if ($hasPattern) {
                    $alamat_parts[] = trim($record->nama_kec_asal);
                    echo "✅ Found address in nama_kec_asal: '{$record->nama_kec_asal}'\n";
                }
            }
            
            // Check no_kec_asal
            if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                $alamat_parts[] = trim($record->no_kec_asal);
                echo "✅ Found location in no_kec_asal: '{$record->no_kec_asal}'\n";
            }
            
            $result = !empty($alamat_parts) ? implode(', ', array_slice($alamat_parts, 0, 2)) : 'Data alamat bermasalah';
            
            echo "\nResult: '{$result}'\n";
        }
        
    } else {
        echo "Data MONA tidak ditemukan. Mungkin sudah dihapus.\n";
        
        // Cari data dengan alamat_asal = '32'
        echo "\nMencari data dengan alamat_asal = '32'...\n";
        $problemRecord = DB::table('datang2024')->where('alamat_asal', '32')->first();
        
        if ($problemRecord) {
            echo "\n=== Found record with alamat_asal = '32' ===\n";
            echo "Nama: {$problemRecord->nama_lengkap}\n";
            echo "alamat_asal: '{$problemRecord->alamat_asal}' (PROBLEM!)\n";
            echo "nama_kec_asal: '{$problemRecord->nama_kec_asal}' (Real address?)\n";
            echo "no_kec_asal: '{$problemRecord->no_kec_asal}' (Location?)\n";
            
            // Apply fix
            $alamat_parts = [];
            
            if (!empty($problemRecord->nama_kec_asal) && !is_numeric($problemRecord->nama_kec_asal)) {
                $hasPattern = (
                    strpos(strtoupper($problemRecord->nama_kec_asal), 'DUSUN') !== false || 
                    strpos(strtoupper($problemRecord->nama_kec_asal), 'JL.') !== false ||
                    strpos(strtoupper($problemRecord->nama_kec_asal), 'KP ') !== false ||
                    strpos(strtoupper($problemRecord->nama_kec_asal), 'LINGKUNGAN') !== false
                );
                
                if ($hasPattern) {
                    $alamat_parts[] = trim($problemRecord->nama_kec_asal);
                }
            }
            
            if (!empty($problemRecord->no_kec_asal) && !is_numeric($problemRecord->no_kec_asal)) {
                $alamat_parts[] = trim($problemRecord->no_kec_asal);
            }
            
            $fixed_alamat = !empty($alamat_parts) ? implode(', ', array_slice($alamat_parts, 0, 2)) : 'Data alamat bermasalah';
            
            echo "\nFIXED ALAMAT: '{$fixed_alamat}'\n";
            echo "IMPROVEMENT: " . ($fixed_alamat !== '32' ? "✅ YES" : "❌ NO") . "\n";
        } else {
            echo "Tidak ada data dengan alamat_asal = '32' di datang2024\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}