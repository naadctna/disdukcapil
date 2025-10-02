<?php
try {
    // Test connection using Laravel's .env config
    $host = '10.32.7.30';
    $database = 'test';
    $username = 'odbcuser';
    $password = 'passwordku';
    
    echo "=== TEST KONEKSI DATABASE ===\n";
    echo "Host: $host\n";
    echo "Database: $database\n";
    echo "Username: $username\n";
    echo "Password: " . str_repeat('*', strlen($password)) . "\n\n";
    
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Koneksi ke database 'test' BERHASIL!\n\n";
    
    // Check tables
    echo "=== CHECKING TABLES ===\n";
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Total tables found: " . count($tables) . "\n";
    
    if (count($tables) > 0) {
        echo "Tables in database:\n";
        foreach($tables as $table) {
            echo "  - $table\n";
        }
    } else {
        echo "No tables found in database 'test'\n";
    }
    
    // Check if our required tables exist
    $requiredTables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    $missingTables = [];
    
    echo "\n=== CHECKING REQUIRED TABLES ===\n";
    foreach($requiredTables as $table) {
        if (in_array($table, $tables)) {
            echo "✓ $table - exists\n";
        } else {
            echo "✗ $table - missing\n";
            $missingTables[] = $table;
        }
    }
    
    if (!empty($missingTables)) {
        echo "\n⚠️  Missing tables: " . implode(', ', $missingTables) . "\n";
        echo "Need to run migrations to create these tables.\n";
    } else {
        echo "\n✅ All required tables exist!\n";
    }
    
} catch(Exception $e) {
    echo "✗ Koneksi GAGAL: " . $e->getMessage() . "\n";
    echo "\nPossible issues:\n";
    echo "- Server 10.32.7.30 tidak dapat diakses\n";
    echo "- Username/password salah\n";
    echo "- Database 'test' tidak exist\n";
    echo "- Firewall blocking connection\n";
}
?>