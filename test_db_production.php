<?php
try {
    // Menggunakan konfigurasi dari .env
    $pdo = new PDO('mysql:host=19.32.7.30;dbname=test', 'odbcuser', 'passwordku');
    echo "=== TEST KONEKSI DATABASE TEST ===\n\n";
    
    echo "✓ Koneksi berhasil ke database 'test'\n";
    echo "  Host: 19.32.7.30\n";
    echo "  Database: test\n";
    echo "  Username: odbcuser\n\n";
    
    // Cek tabel yang ada
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tabel yang ditemukan: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        echo "Daftar tabel:\n";
        foreach($tables as $table) {
            echo "  - " . $table . "\n";
        }
    } else {
        echo "Tidak ada tabel dalam database 'test'\n";
    }
    
    // Cek apakah tabel yang kita butuhkan ada
    $requiredTables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    $missingTables = [];
    
    echo "\nCek tabel yang dibutuhkan:\n";
    foreach($requiredTables as $table) {
        if (in_array($table, $tables)) {
            echo "  ✓ $table - ADA\n";
        } else {
            echo "  ✗ $table - TIDAK ADA\n";
            $missingTables[] = $table;
        }
    }
    
    if (!empty($missingTables)) {
        echo "\n⚠️  Tabel yang hilang: " . implode(', ', $missingTables) . "\n";
        echo "Perlu run migration untuk membuat tabel-tabel ini.\n";
    } else {
        echo "\n✅ Semua tabel yang dibutuhkan sudah ada!\n";
    }
    
} catch(Exception $e) {
    echo "❌ Error koneksi database: " . $e->getMessage() . "\n";
    echo "\nKemungkinan masalah:\n";
    echo "1. Server database tidak bisa diakses\n";
    echo "2. Username/password salah\n";
    echo "3. Database 'test' tidak ada\n";
    echo "4. Firewall memblokir koneksi\n";
}
?>