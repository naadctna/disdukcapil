<?php

require_once __DIR__ . '/vendor/autoload.php';

// Test upload processor sederhana
echo "=== TEST UPLOAD PROCESSOR ===\n\n";

// Simulate file upload processing
$testFile = 'public/test_all_caps_underscore.csv';

if (file_exists($testFile)) {
    echo "✅ Test file exists: {$testFile}\n\n";
    
    // Read and parse CSV
    $handle = fopen($testFile, 'r');
    $headers = fgetcsv($handle);
    
    echo "Headers found:\n";
    foreach ($headers as $index => $header) {
        echo "  [{$index}] {$header}\n";
    }
    echo "\n";
    
    // Read first data row
    $firstRow = fgetcsv($handle);
    fclose($handle);
    
    echo "First row data:\n";
    foreach ($firstRow as $index => $value) {
        echo "  [{$index}] {$value}\n";
    }
    echo "\n";
    
    // Test mapping process
    echo "=== MAPPING TEST ===\n";
    
    $rowData = [];
    for ($i = 0; $i < count($headers); $i++) {
        $key = strtolower(trim($headers[$i]));
        $value = isset($firstRow[$i]) ? trim($firstRow[$i]) : '';
        $rowData[$key] = $value;
    }
    
    echo "Row data (normalized keys):\n";
    foreach ($rowData as $key => $value) {
        echo "  '{$key}' => '{$value}'\n";
    }
    echo "\n";
    
    // Test field detection
    $fieldMappings = [
        'no_kk' => ['kk', 'no_kk', 'nokk', 'nomor_kk', 'nomorkk'],
        'nik' => ['nik', 'nomor_ktp', 'nomorktp', 'ktp_no', 'no_ktp'],
        'nama' => ['nama', 'nama_lengkap', 'namalengkap', 'full_name'],
        'tanggal_pindah' => ['tanggal_pindah', 'tanggalpindah', 'tgl_pindah']
    ];
    
    $mapped = [];
    foreach ($fieldMappings as $targetField => $variations) {
        foreach ($variations as $variation) {
            $normalizedVar = strtolower(str_replace([' ', '_', '-', '.'], '', $variation));
            
            foreach ($rowData as $key => $value) {
                $normalizedKey = strtolower(str_replace([' ', '_', '-', '.'], '', $key));
                
                if ($normalizedKey === $normalizedVar && !empty($value)) {
                    $mapped[$targetField] = $value;
                    echo "✅ MAPPED: {$targetField} = '{$value}' (from '{$key}')\n";
                    break 2;
                }
            }
        }
    }
    
    echo "\nFinal mapped data:\n";
    foreach ($mapped as $field => $value) {
        echo "  {$field}: {$value}\n";
    }
    
} else {
    echo "❌ Test file not found: {$testFile}\n";
}

echo "\n=== TEST COMPLETED ===\n";
?>