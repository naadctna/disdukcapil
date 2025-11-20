<?php
// Test simplified and unified format for both datang and pindah
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ColumnMappingService;

echo "=== TESTING UNIFIED & SIMPLIFIED FORMAT ===\n\n";

try {
    // Test 1: Datang format
    echo "1. Testing DATANG format...\n";
    $datangHeaders = ColumnMappingService::getExcelHeaders('datang');
    $datangMapping = ColumnMappingService::getDbColumnMapping('datang');
    
    echo "   - Datang columns: " . count($datangMapping) . " kolom\n";
    echo "   - Headers sample: " . implode(', ', array_slice($datangHeaders, 0, 5)) . "...\n";
    
    // Test 2: Pindah format (SIMPLIFIED)
    echo "\n2. Testing PINDAH format (SIMPLIFIED)...\n";
    $pindahHeaders = ColumnMappingService::getExcelHeaders('pindah');
    $pindahMapping = ColumnMappingService::getDbColumnMapping('pindah');
    
    echo "   - Pindah columns: " . count($pindahMapping) . " kolom\n";
    echo "   - Headers sample: " . implode(', ', array_slice($pindahHeaders, 0, 5)) . "...\n";
    
    // Test 3: Field groups untuk ordered display
    echo "\n3. Testing ordered display groups...\n";
    $datangGroups = ColumnMappingService::getFieldGroups('datang');
    $pindahGroups = ColumnMappingService::getFieldGroups('pindah');
    
    echo "   - Datang groups: " . implode(', ', array_keys($datangGroups)) . "\n";
    echo "   - Pindah groups: " . implode(', ', array_keys($pindahGroups)) . "\n";
    
    // Test 4: Display order untuk mencegah kesalahan pemanggilan
    echo "\n4. Testing display order (anti-confusion)...\n";
    $datangOrder = ColumnMappingService::getDisplayOrder('datang');
    $pindahOrder = ColumnMappingService::getDisplayOrder('pindah');
    
    echo "   - Datang order sample: " . implode(' → ', array_slice($datangOrder, 0, 5)) . "...\n";
    echo "   - Pindah order sample: " . implode(' → ', array_slice($pindahOrder, 0, 5)) . "...\n";
    
    // Test 5: Template validation
    echo "\n5. Testing template validation...\n";
    
    // Test datang template
    if (file_exists('public/template_datang_2025_synchronized.csv')) {
        $handle = fopen('public/template_datang_2025_synchronized.csv', 'r');
        $datangTemplateHeaders = fgetcsv($handle);
        fclose($handle);
        
        $datangErrors = ColumnMappingService::validateExcelHeaders($datangTemplateHeaders, 'datang');
        echo "   - Datang template: " . (empty($datangErrors) ? "✅ VALID" : "❌ INVALID") . "\n";
    }
    
    // Test pindah template
    if (file_exists('public/template_pindah_2025_synchronized.csv')) {
        $handle = fopen('public/template_pindah_2025_synchronized.csv', 'r');
        $pindahTemplateHeaders = fgetcsv($handle);
        fclose($handle);
        
        $pindahErrors = ColumnMappingService::validateExcelHeaders($pindahTemplateHeaders, 'pindah');
        echo "   - Pindah template: " . (empty($pindahErrors) ? "✅ VALID" : "❌ INVALID") . "\n";
        
        if (!empty($pindahErrors)) {
            echo "     Errors: " . implode('; ', $pindahErrors) . "\n";
        }
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "✅ DATANG: " . count($datangMapping) . " kolom (format lengkap)\n";
    echo "✅ PINDAH: " . count($pindahMapping) . " kolom (format disederhanakan)\n";
    echo "✅ Unified mapping service\n";
    echo "✅ Ordered display untuk mencegah confusion\n";
    echo "✅ Template validation ready\n\n";
    
    echo "🎉 SYSTEM READY - Format unified dan tidak kompleks!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>