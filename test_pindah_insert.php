<?php
// Test insert pindah data dengan format yang sudah disederhanakan
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ColumnMappingService;

echo "=== TESTING PINDAH DATA INSERT ===\n\n";

try {
    // Test insert sample pindah data
    echo "1. Testing pindah data insertion...\n";
    
    $testData = [
        'nik' => '3201234567890123',
        'no_kk' => '3201234567890001',
        'nama_lengkap' => 'MARIA GONZALEZ',
        'no_pindah' => 'P2025001',
        'tgl_pindah' => '2025-01-25',
        'klasifikasi_pindah' => 'ANTAR KABUPATEN',
        'no_prop_asal' => '32',
        'nama_prop_asal' => 'JAWA BARAT',
        'no_kab_asal' => '3201',
        'nama_kab_asal' => 'BOGOR',
        'no_kec_asal' => '320101',
        'nama_kec_asal' => 'BOGOR SELATAN',
        'no_kel_asal' => '3201011001',
        'nama_kel_asal' => 'CIKONENG',
        'alamat_asal' => 'JL. VETERAN NO. 111',
        'no_rt_asal' => '001',
        'no_rw_asal' => '002',
        'no_prop_tujuan' => '32',
        'nama_prop_tujuan' => 'JAWA BARAT',
        'no_kab_tujuan' => '3273',
        'nama_kab_tujuan' => 'KOTA BOGOR',
        'no_kec_tujuan' => '327301',
        'nama_kec_tujuan' => 'BOGOR TENGAH',
        'no_kel_tujuan' => '3273011001',
        'nama_kel_tujuan' => 'GUDANG',
        'alamat_tujuan' => 'JL. PROKLAMASI NO. 222',
        'no_rt_tujuan' => '003',
        'no_rw_tujuan' => '004',
        'kode' => 'P001',
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    $inserted = DB::table('pindah2025')->insert($testData);
    
    if ($inserted) {
        echo "✅ Pindah data insertion successful!\n\n";
        
        // Verify inserted data
        $record = DB::table('pindah2025')->first();
        echo "2. Data verification:\n";
        echo "   - ID: {$record->id}\n";
        echo "   - NIK: {$record->nik}\n";
        echo "   - Nama: {$record->nama_lengkap}\n";
        echo "   - No Pindah: {$record->no_pindah}\n";
        echo "   - Kode Provinsi Asal: {$record->no_prop_asal}\n";
        echo "   - Nama Provinsi Asal: {$record->nama_prop_asal}\n";
        echo "   - Alamat Asal: {$record->alamat_asal}\n";
        echo "   - Alamat Tujuan: {$record->alamat_tujuan}\n";
        echo "   - Tanggal: {$record->tgl_pindah}\n\n";
        
        // Test formatted display
        echo "3. Testing formatted display (ordered):\n";
        $formatted = ColumnMappingService::formatDisplayData($record, 'pindah');
        
        foreach (array_slice($formatted, 0, 8) as $item) { // Show first 8 fields
            echo "   - {$item['label']}: {$item['value']}\n";
        }
        
        echo "\n✅ PINDAH FORMAT TEST COMPLETED!\n";
        echo "🔗 Check http://localhost:8000/penduduk for display verification\n";
        
    } else {
        echo "❌ Pindah data insertion failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>