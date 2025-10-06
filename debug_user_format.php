<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

use App\Http\Controllers\ExcelUploadController;

// Test dengan format yang user pakai
$controller = new ExcelUploadController();
$reflection = new ReflectionClass($controller);
$mapMethod = $reflection->getMethod('mapRowData');
$mapMethod->setAccessible(true);
$validateMethod = $reflection->getMethod('validateRowData');
$validateMethod->setAccessible(true);

echo "=== Test Format User: Nama, Alamat, Tanggal Datang ===\n";
$headers = ['Nama', 'Alamat', 'Tanggal Datang'];
$data = ['John Doe', 'Jl. Merdeka No. 123', '2025-01-15'];

echo "Headers: ";
print_r($headers);
echo "Data: ";
print_r($data);

$result = $mapMethod->invokeArgs($controller, [$headers, $data, 'datang']);
echo "Mapped Result:\n";
print_r($result);

$isValid = $validateMethod->invokeArgs($controller, [$result, 'datang']);
echo "Validation Result: " . ($isValid ? 'VALID' : 'INVALID') . "\n";

if (!$isValid) {
    echo "Debug validation:\n";
    echo "- nama empty? " . (empty($result['nama']) ? 'YES' : 'NO') . "\n";
    echo "- alamat empty? " . (empty($result['alamat'] ?? '') ? 'YES' : 'NO') . "\n";  
    echo "- tanggal_datang empty? " . (empty($result['tanggal_datang'] ?? '') ? 'YES' : 'NO') . "\n";
    echo "Available keys: " . implode(', ', array_keys($result)) . "\n";
}