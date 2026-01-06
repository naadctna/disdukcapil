<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== Checking pindah2025 table structure ===\n\n";

$columns = Schema::getColumnListing('pindah2025');
echo "All columns in pindah2025:\n";
print_r($columns);

echo "\n\n=== Sample data from pindah2025 ===\n\n";
$data = DB::table('pindah2025')->limit(3)->get();
foreach ($data as $row) {
    echo "ID: {$row->id}\n";
    echo "Nama: " . ($row->nama_lengkap ?? $row->nama ?? 'N/A') . "\n";
    
    // Check all possible date columns
    $dateColumns = ['tanggal_pindah', 'tgl_pindah', 'tanggal', 'tgl_datang', 'tanggal_datang'];
    foreach ($dateColumns as $col) {
        if (property_exists($row, $col)) {
            echo "$col: " . ($row->$col ?? 'NULL') . "\n";
        }
    }
    echo "---\n";
}
