<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=disdukcapil', 'root', '');
    echo "Database connection: SUCCESS\n\n";
    
    $tables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    
    foreach($tables as $table) {
        echo "Structure of table '$table':\n";
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($columns as $column) {
            echo "  - " . $column['Field'] . " (" . $column['Type'] . ")\n";
        }
        echo "\n";
    }
    
    // Test with correct column names
    echo "Testing data insertion with correct column names:\n";
    
    // Let's check what the actual columns are and try to insert
    $stmt = $pdo->query("DESCRIBE datang2024");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $columnNames = array_column($columns, 'Field');
    
    echo "Columns in datang2024: " . implode(', ', $columnNames) . "\n";
    
    // Try inserting with the available columns (excluding id and timestamps)
    $insertColumns = array_filter($columnNames, function($col) {
        return !in_array($col, ['id', 'created_at', 'updated_at']);
    });
    
    if (!empty($insertColumns)) {
        $insertValues = array_fill(0, count($insertColumns), 'Test Value');
        $placeholders = str_repeat('?,', count($insertColumns) - 1) . '?';
        
        $sql = "INSERT INTO datang2024 (" . implode(',', $insertColumns) . ") VALUES ($placeholders)";
        echo "SQL: $sql\n";
        
        $insertStmt = $pdo->prepare($sql);
        $result = $insertStmt->execute($insertValues);
        
        if ($result) {
            echo "✓ Data inserted successfully!\n";
            
            // Get the inserted data
            $selectStmt = $pdo->query("SELECT * FROM datang2024 ORDER BY id DESC LIMIT 1");
            $lastRecord = $selectStmt->fetch(PDO::FETCH_ASSOC);
            echo "Last inserted record: " . json_encode($lastRecord) . "\n";
        } else {
            echo "✗ Failed to insert data\n";
        }
    }
    
} catch(Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>