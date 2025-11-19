<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Checking both tables for corrupted data ===\n\n";
    
    // Check datang2024
    $count2024 = DB::table('datang2024')->count();
    echo "datang2024 total records: $count2024\n";
    
    if ($count2024 > 0) {
        echo "\nSample data from datang2024:\n";
        $samples = DB::table('datang2024')->limit(3)->get();
        
        foreach ($samples as $i => $record) {
            echo "--- Record " . ($i+1) . " ---\n";
            echo "nama_lengkap: '{$record->nama_lengkap}'\n";
            echo "alamat_asal: '{$record->alamat_asal}'\n";
            echo "nama_kec_asal: '{$record->nama_kec_asal}'\n";
            echo "no_kec_asal: '{$record->no_kec_asal}'\n";
            
            // Test if problematic
            $isProblematic = is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3;
            echo "Problematic? " . ($isProblematic ? "YES" : "NO") . "\n";
            
            if ($isProblematic) {
                // Apply smart fix
                $alamat_parts = [];
                
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                    $hasPattern = (
                        strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                        strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                        strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                        strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false
                    );
                    
                    if ($hasPattern) {
                        $alamat_parts[] = trim($record->nama_kec_asal);
                    }
                }
                
                if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                    $alamat_parts[] = trim($record->no_kec_asal);
                }
                
                $fixed_alamat = !empty($alamat_parts) ? implode(', ', array_slice($alamat_parts, 0, 2)) : 'Data alamat bermasalah';
                echo "SMART FIX: '{$fixed_alamat}'\n";
            }
            echo "\n";
        }
    }
    
    // Check datang2025
    $count2025 = DB::table('datang2025')->count();
    echo "datang2025 total records: $count2025\n";
    
    if ($count2025 > 0) {
        echo "\nSample data from datang2025:\n";
        $samples = DB::table('datang2025')->limit(3)->get();
        
        foreach ($samples as $i => $record) {
            echo "--- Record " . ($i+1) . " ---\n";
            echo "nama_lengkap: '{$record->nama_lengkap}'\n";
            echo "alamat_asal: '{$record->alamat_asal}'\n";
            echo "nama_kec_asal: '{$record->nama_kec_asal}'\n";
            echo "no_kec_asal: '{$record->no_kec_asal}'\n";
            
            // Test if problematic
            $isProblematic = is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3;
            echo "Problematic? " . ($isProblematic ? "YES" : "NO") . "\n";
            
            if ($isProblematic) {
                // Apply smart fix
                $alamat_parts = [];
                
                if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal)) {
                    $hasPattern = (
                        strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                        strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                        strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                        strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false
                    );
                    
                    if ($hasPattern) {
                        $alamat_parts[] = trim($record->nama_kec_asal);
                    }
                }
                
                if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                    $alamat_parts[] = trim($record->no_kec_asal);
                }
                
                $fixed_alamat = !empty($alamat_parts) ? implode(', ', array_slice($alamat_parts, 0, 2)) : 'Data alamat bermasalah';
                echo "SMART FIX: '{$fixed_alamat}'\n";
            }
            echo "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}