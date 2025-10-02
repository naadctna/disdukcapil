<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=disdukcapil', 'root', '');
    echo "Database connection: SUCCESS\n";
    
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . count($tables) . "\n";
    
    foreach($tables as $table) {
        echo "- " . $table . "\n";
    }
    
    // Test inserting data
    echo "\nTesting data insertion:\n";
    
    // Check if datang2024 table exists and insert test data
    if (in_array('datang2024', $tables)) {
        echo "Testing datang2024 table...\n";
        $insertStmt = $pdo->prepare("INSERT INTO datang2024 (nama, alamat, tanggal) VALUES (?, ?, ?)");
        $result = $insertStmt->execute(['Test User', 'Test Address', date('Y-m-d')]);
        
        if ($result) {
            echo "✓ Data inserted successfully into datang2024\n";
            
            // Get the inserted data
            $selectStmt = $pdo->query("SELECT * FROM datang2024 ORDER BY id DESC LIMIT 1");
            $lastRecord = $selectStmt->fetch(PDO::FETCH_ASSOC);
            echo "Last inserted record: " . json_encode($lastRecord) . "\n";
            
            // Count total records
            $countStmt = $pdo->query("SELECT COUNT(*) as total FROM datang2024");
            $count = $countStmt->fetch(PDO::FETCH_ASSOC);
            echo "Total records in datang2024: " . $count['total'] . "\n";
        } else {
            echo "✗ Failed to insert data into datang2024\n";
        }
    } else {
        echo "✗ datang2024 table not found\n";
    }
    
} catch(Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>