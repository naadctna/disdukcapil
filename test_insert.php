<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

// Test insert ke database
$testData = [
    'nama' => 'Test User',
    'alamat' => 'Jl. Test No. 123',
    'tanggal_datang' => '2025-01-15',
    'created_at' => now(),
    'updated_at' => now()
];

echo "Testing insert to datang2024 table...\n";
echo "Data to insert:\n";
print_r($testData);

try {
    DB::table('datang2024')->insert($testData);
    echo "✅ INSERT BERHASIL!\n";
    
    // Cek data
    $count = DB::table('datang2024')->count();
    echo "Total records in datang2024: $count\n";
    
    // Ambil data terakhir
    $lastRecord = DB::table('datang2024')->orderBy('id', 'desc')->first();
    echo "Last record:\n";
    print_r($lastRecord);
    
} catch (Exception $e) {
    echo "❌ INSERT GAGAL: " . $e->getMessage() . "\n";
}