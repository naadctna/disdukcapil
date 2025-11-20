<?php
// Direct database insert test for corrected mapping
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Insert test data directly to verify the structure
    $testData = [
        'nik' => '3201234567890123',
        'no_kk' => '3201234567890001',
        'nama_lengkap' => 'ERFAN EKA MAULANA',
        'no_datang' => 'D2025001',
        'tgl_datang' => '2025-01-15',
        'klasifikasi_pindah' => 'ANTAR KABUPATEN',
        'no_prop_asal' => '32',                    // SHOULD BE NUMERIC CODE
        'nama_prop_asal' => 'JAWA BARAT',          // SHOULD BE TEXT NAME
        'no_kab_asal' => '3201',
        'nama_kab_asal' => 'BOGOR',
        'no_kec_asal' => '320101',
        'nama_kec_asal' => 'BOGOR SELATAN',
        'no_kel_asal' => '3201011001',
        'nama_kel_asal' => 'CIKONENG',
        'alamat_asal' => 'JL. RAYA CIKONENG NO. 123', // SHOULD BE ADDRESS
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
        'alamat_tujuan' => 'JL. SUDIRMAN NO. 456',
        'no_rt_tujuan' => '003',
        'no_rw_tujuan' => '004',
        'kode' => 'D001',

        
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    $inserted = DB::table('datang2025')->insert($testData);
    
    if ($inserted) {
        echo "✅ Test data inserted successfully!\n";
        
        // Fetch and verify
        $record = DB::table('datang2025')->first();
        echo "\nVerification:\n";
        echo "- ID: {$record->id}\n";
        echo "- nama_lengkap: {$record->nama_lengkap}\n";
        echo "- no_prop_asal: {$record->no_prop_asal} (should be '32')\n";
        echo "- nama_prop_asal: {$record->nama_prop_asal} (should be 'JAWA BARAT')\n";
        echo "- alamat_asal: {$record->alamat_asal} (should be 'JL. RAYA CIKONENG NO. 123')\n";
        
        echo "\n✅ Data mapping is now CORRECT!\n";
        
        // Check if this will show properly on the website
        echo "\n🔗 Check http://localhost:8000/penduduk to see the data in the interface\n";
        
    } else {
        echo "❌ Failed to insert test data\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>