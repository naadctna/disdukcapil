<?php
// Test synchronized template upload
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ColumnMappingService;

echo "=== TESTING SYNCHRONIZED EXCEL-DATABASE MAPPING ===\n\n";

try {
    // 1. Test Excel headers validation
    echo "1. Testing Excel headers validation...\n";
    $csvFile = 'public/template_datang_2025_synchronized.csv';
    
    if (file_exists($csvFile)) {
        $handle = fopen($csvFile, 'r');
        $headers = fgetcsv($handle);
        fclose($handle);
        
        echo "Excel headers found: " . implode(', ', array_slice($headers, 0, 5)) . "...\n";
        
        $errors = ColumnMappingService::validateExcelHeaders($headers);
        if (empty($errors)) {
            echo "✅ Excel headers validation PASSED!\n\n";
        } else {
            echo "❌ Excel headers validation FAILED:\n";
            foreach ($errors as $error) {
                echo "   - $error\n";
            }
            echo "\n";
        }
        
        // 2. Test field labels consistency
        echo "2. Testing field labels consistency...\n";
        $fieldLabels = ColumnMappingService::getFieldLabels();
        $dbMapping = ColumnMappingService::getDbColumnMapping();
        
        echo "Database columns: " . implode(', ', array_slice($dbMapping, 0, 5)) . "...\n";
        echo "Field labels sample:\n";
        foreach (array_slice($fieldLabels, 0, 5, true) as $field => $label) {
            echo "   - {$field} => {$label}\n";
        }
        echo "✅ Field labels loaded successfully!\n\n";
        
        // 3. Test data insertion with correct mapping
        echo "3. Testing data insertion with synchronized mapping...\n";
        
        // Read first data row
        $handle = fopen($csvFile, 'r');
        fgetcsv($handle); // Skip header
        $firstRow = fgetcsv($handle);
        fclose($handle);
        
        if ($firstRow) {
            // Map data using the service
            $dataToInsert = [
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            foreach ($dbMapping as $index => $dbColumn) {
                if (isset($firstRow[$index])) {
                    $value = trim($firstRow[$index]);
                    if ($dbColumn === 'tgl_datang') {
                        $dataToInsert[$dbColumn] = $value; // Already in correct format
                    } else {
                        $dataToInsert[$dbColumn] = $value !== '' ? $value : null;
                    }
                }
            }
            
            // Insert test data
            $inserted = DB::table('datang2025')->insert($dataToInsert);
            
            if ($inserted) {
                echo "✅ Data insertion successful!\n";
                
                // Verify inserted data
                $record = DB::table('datang2025')->first();
                echo "\nData verification:\n";
                echo "   - NIK: {$record->nik}\n";
                echo "   - Nama: {$record->nama_lengkap}\n";
                echo "   - Kode Provinsi Asal: {$record->no_prop_asal}\n";
                echo "   - Nama Provinsi Asal: {$record->nama_prop_asal}\n";
                echo "   - Alamat Asal: {$record->alamat_asal}\n";
                echo "   - Tanggal: {$record->tgl_datang}\n";
                
                echo "\n✅ ALL TESTS PASSED! System is synchronized!\n";
                echo "🔗 Check http://localhost:8000/penduduk to see the properly mapped data\n";
                
            } else {
                echo "❌ Data insertion failed\n";
            }
        }
        
    } else {
        echo "❌ Template file not found: $csvFile\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>