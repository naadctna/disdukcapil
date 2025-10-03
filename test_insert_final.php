<?php
try {
    $pdo = new PDO('mysql:host=10.32.7.30;dbname=test', 'odbcuser', 'passwordku');
    echo "=== TEST INPUT DATA KE DATABASE TEST ===\n\n";
    
    // Test insert ke datang2024
    echo "Testing insert ke datang2024:\n";
    $stmt = $pdo->prepare("INSERT INTO datang2024 (NAMA_LENGKAP, ALAMAT_TUJUAN, TGL_DATANG) VALUES (?, ?, ?)");
    $result = $stmt->execute(['John Doe Test', 'Jl. Sudirman No. 123 Jakarta', '2024-10-03']);
    
    if ($result) {
        echo "✓ Insert datang2024 berhasil!\n";
    } else {
        echo "✗ Insert datang2024 gagal!\n";
    }
    
    // Test insert ke pindah2025  
    echo "\nTesting insert ke pindah2025:\n";
    $stmt2 = $pdo->prepare("INSERT INTO pindah2025 (NAMA_LENGKAP, ALAMAT_ASAL, ALAMAT_TUJUAN, TGL_PINDAH) VALUES (?, ?, ?, ?)");
    $result2 = $stmt2->execute(['Jane Smith Test', 'Jl. Thamrin Jakarta', 'Jl. Gatot Subroto Bandung', '2025-10-03']);
    
    if ($result2) {
        echo "✓ Insert pindah2025 berhasil!\n";
    } else {
        echo "✗ Insert pindah2025 gagal!\n";
    }
    
    // Cek jumlah data
    echo "\n=== SUMMARY DATA ===\n";
    $tables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "$table: " . $count['total'] . " records\n";
    }
    
    echo "\n✅ Database siap dan bisa menerima input!\n";
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>