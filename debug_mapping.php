<?php

// Test debug untuk sistem mapping
$testHeaders = ['NO_KK', 'NOMOR_KTP', 'NAMA_LENGKAP', 'ALAMAT_ASAL', 'ALAMAT_TUJUAN', 'TANGGAL_PINDAH'];
$testData = ['3201234567890123', '3201010101990001', 'John Doe', 'Jl. Sudirman 1', 'Jl. Gatot Subroto 10', '2024-11-15'];

echo "=== DEBUG SISTEM MAPPING ===\n\n";

// Test key variations generator
function generateKeyVariations($key) {
    $variations = [];
    $cleanKey = trim($key);
    
    // Original key
    $variations[] = $cleanKey;
    $variations[] = strtolower($cleanKey);
    $variations[] = strtoupper($cleanKey);
    
    // Remove spaces, underscores, dashes, dots
    $noSpaces = str_replace([' ', '_', '-', '.', '(', ')', '[', ']'], '', $cleanKey);
    $variations[] = $noSpaces;
    $variations[] = strtolower($noSpaces);
    $variations[] = strtoupper($noSpaces);
    
    // Replace underscores with spaces
    $withSpaces = str_replace(['_', '-', '.'], ' ', $cleanKey);
    $variations[] = $withSpaces;
    $variations[] = strtolower($withSpaces);
    
    $withUnderscores = str_replace([' ', '-', '.'], '_', $cleanKey);
    $variations[] = $withUnderscores;
    $variations[] = strtolower($withUnderscores);
    $variations[] = strtoupper($withUnderscores);
    
    return array_unique($variations);
}

// Test mapping untuk setiap header
foreach ($testHeaders as $index => $header) {
    echo "Header: {$header}\n";
    echo "Value: {$testData[$index]}\n";
    
    $variations = generateKeyVariations($header);
    echo "Generated variations (" . count($variations) . "):\n";
    foreach ($variations as $var) {
        echo "  - '{$var}'\n";
    }
    echo "\n";
}

echo "=== TEST FIELD DETECTION ===\n\n";

// Test field mappings
$fieldMappings = [
    'no_kk' => ['kk', 'no_kk', 'nokk', 'nomor_kk', 'nomorkk', 'NO_KK', 'NOMOR_KK'],
    'nik' => ['nik', 'nomor_ktp', 'nomorktp', 'NIK', 'NOMOR_KTP', 'NO_KTP'],
    'nama' => ['nama', 'nama_lengkap', 'namalengkap', 'NAMA', 'NAMA_LENGKAP'],
];

foreach ($testHeaders as $header) {
    echo "Testing header: {$header}\n";
    
    foreach ($fieldMappings as $targetField => $variations) {
        $headerVariations = generateKeyVariations($header);
        
        foreach ($variations as $variation) {
            $variationKeys = generateKeyVariations($variation);
            
            $found = false;
            foreach ($headerVariations as $headerVar) {
                foreach ($variationKeys as $varKey) {
                    if ($headerVar === $varKey) {
                        echo "  ✅ MATCH: {$targetField} <- {$header} (via {$variation})\n";
                        $found = true;
                        break 2;
                    }
                }
            }
            if ($found) break;
        }
    }
    echo "\n";
}

echo "=== DEBUG COMPLETED ===\n";
?>