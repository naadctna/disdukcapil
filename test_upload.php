<?php
// Simple upload test script
require_once 'vendor/autoload.php';

use Illuminate\Http\UploadedFile;
use App\Http\Controllers\ExcelUploadController;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create a mock uploaded file
$filePath = 'test_datang_2025.csv';
if (!file_exists($filePath)) {
    echo "File $filePath not found!\n";
    exit(1);
}

// Read and process the CSV manually for testing
$csvData = [];
$handle = fopen($filePath, 'r');
if ($handle) {
    $header = fgetcsv($handle); // Read header
    echo "CSV Header: " . implode(', ', $header) . "\n";
    echo "Total columns in CSV: " . count($header) . "\n";
    
    // Read first data row
    $firstRow = fgetcsv($handle);
    if ($firstRow) {
        echo "\nFirst row data:\n";
        for ($i = 0; $i < count($firstRow) && $i < count($header); $i++) {
            echo "$i => {$header[$i]} = {$firstRow[$i]}\n";
        }
    }
    
    fclose($handle);
}

echo "\nTest completed successfully!\n";
?>