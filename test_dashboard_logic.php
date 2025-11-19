<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Testing DashboardController Logic ===\n\n";
    
    // Check if table exists
    $count = DB::table('datang2025')->count();
    echo "datang2025 record count: $count\n\n";
    
    if ($count == 0) {
        echo "No records in datang2025\n";
        exit;
    }
    
    // Simulate what DashboardController does
    $records = DB::table('datang2025')->limit(5)->get();
    
    foreach ($records as $i => $record) {
        echo "--- Test Record " . ($i+1) . ": {$record->nama_lengkap} ---\n";
        
        // Apply the same logic as DashboardController
        $isProblematic = is_numeric(trim($record->alamat_asal ?? '')) || strlen(trim($record->alamat_asal ?? '')) <= 3;
        
        if ($isProblematic) {
            echo "🔧 Detected corrupted alamat: '{$record->alamat_asal}'\n";
            
            $alamat_parts = [];
            
            // Smart detection from nama_kec_asal
            if (!empty($record->nama_kec_asal) && !is_numeric($record->nama_kec_asal) &&
                (strpos(strtoupper($record->nama_kec_asal), 'DUSUN') !== false || 
                 strpos(strtoupper($record->nama_kec_asal), 'JL.') !== false ||
                 strpos(strtoupper($record->nama_kec_asal), 'KP ') !== false ||
                 strpos(strtoupper($record->nama_kec_asal), 'LINGKUNGAN') !== false ||
                 strpos(strtoupper($record->nama_kec_asal), 'CILETENG') !== false ||
                 strpos(strtoupper($record->nama_kec_asal), 'CUKANG') !== false)) {
                $alamat_parts[] = trim($record->nama_kec_asal);
                echo "✅ Found address pattern in nama_kec_asal: '{$record->nama_kec_asal}'\n";
            }
            
            // Check no_kec_asal
            if (!empty($record->no_kec_asal) && !is_numeric($record->no_kec_asal)) {
                $alamat_parts[] = trim($record->no_kec_asal);
                echo "✅ Found location in no_kec_asal: '{$record->no_kec_asal}'\n";
            }
            
            // Fallback to nama_kel_asal
            if (empty($alamat_parts) && !empty($record->nama_kel_asal) && !is_numeric($record->nama_kel_asal)) {
                $alamat_parts[] = trim($record->nama_kel_asal);
                echo "📍 Using fallback nama_kel_asal: '{$record->nama_kel_asal}'\n";
                
                if (!empty($record->no_prop_asal) && !is_numeric($record->no_prop_asal)) {
                    $alamat_parts[] = trim($record->no_prop_asal);
                    echo "📍 Adding context no_prop_asal: '{$record->no_prop_asal}'\n";
                }
            }
            
            $alamat_display = !empty($alamat_parts) ? 
                implode(', ', array_slice($alamat_parts, 0, 2)) : 
                'Data alamat bermasalah';
        } else {
            echo "✅ Normal alamat found\n";
            $alamat_display = trim($record->alamat_asal);
        }
        
        echo "📍 FINAL DISPLAY: '{$alamat_display}'\n";
        echo "🎯 SUCCESS: " . ($alamat_display !== '32' && $alamat_display !== 'Data alamat bermasalah' ? "YES" : "NO") . "\n\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}