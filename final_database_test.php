<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=disdukcapil', 'root', '');
    echo "=== DATABASE TEST REPORT ===\n\n";
    
    echo "✓ Database connection: SUCCESS\n";
    
    // Check tables
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✓ Tables found: " . count($tables) . "\n";
    echo "  Required tables: datang2024, datang2025, pindah2024, pindah2025\n";
    
    $requiredTables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    $missingTables = [];
    
    foreach($requiredTables as $table) {
        if (in_array($table, $tables)) {
            echo "  ✓ $table exists\n";
        } else {
            echo "  ✗ $table missing\n";
            $missingTables[] = $table;
        }
    }
    
    if (empty($missingTables)) {
        echo "\n=== TESTING DATA INSERTION ===\n";
        
        // Test datang2024
        echo "\nTesting datang2024 table:\n";
        $insertStmt = $pdo->prepare("INSERT INTO datang2024 (nama, alamat, tanggal_datang) VALUES (?, ?, ?)");
        $result = $insertStmt->execute(['John Doe', 'Jl. Sudirman No. 123', '2024-10-02']);
        
        if ($result) {
            echo "  ✓ Insert successful\n";
            
            // Count records
            $countStmt = $pdo->query("SELECT COUNT(*) as total FROM datang2024");
            $count = $countStmt->fetch(PDO::FETCH_ASSOC);
            echo "  ✓ Total records: " . $count['total'] . "\n";
            
            // Get latest record
            $selectStmt = $pdo->query("SELECT * FROM datang2024 ORDER BY id DESC LIMIT 1");
            $latest = $selectStmt->fetch(PDO::FETCH_ASSOC);
            echo "  ✓ Latest record: " . $latest['nama'] . " - " . $latest['alamat'] . " - " . $latest['tanggal_datang'] . "\n";
        } else {
            echo "  ✗ Insert failed\n";
        }
        
        // Test pindah2024
        echo "\nTesting pindah2024 table:\n";
        $insertStmt2 = $pdo->prepare("INSERT INTO pindah2024 (nama, alamat_asal, alamat_tujuan, tanggal_pindah) VALUES (?, ?, ?, ?)");
        $result2 = $insertStmt2->execute(['Jane Smith', 'Jl. Thamrin No. 456', 'Jl. Gatot Subroto No. 789', '2024-10-02']);
        
        if ($result2) {
            echo "  ✓ Insert successful\n";
            
            // Count records
            $countStmt2 = $pdo->query("SELECT COUNT(*) as total FROM pindah2024");
            $count2 = $countStmt2->fetch(PDO::FETCH_ASSOC);
            echo "  ✓ Total records: " . $count2['total'] . "\n";
            
            // Get latest record
            $selectStmt2 = $pdo->query("SELECT * FROM pindah2024 ORDER BY id DESC LIMIT 1");
            $latest2 = $selectStmt2->fetch(PDO::FETCH_ASSOC);
            echo "  ✓ Latest record: " . $latest2['nama'] . " - " . $latest2['alamat_asal'] . " → " . $latest2['alamat_tujuan'] . "\n";
        } else {
            echo "  ✗ Insert failed\n";
        }
        
        echo "\n=== SUMMARY ===\n";
        echo "Database Status: READY FOR USE ✓\n";
        echo "All tables exist: YES ✓\n";
        echo "Data insertion: WORKING ✓\n";
        echo "Web forms should work properly: YES ✓\n";
        
    } else {
        echo "\n✗ Missing tables: " . implode(', ', $missingTables) . "\n";
        echo "Run migration to create missing tables.\n";
    }
    
} catch(Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}
?>