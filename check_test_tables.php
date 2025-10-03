<?php
try {
    $pdo = new PDO('mysql:host=10.32.7.30;dbname=test', 'odbcuser', 'passwordku');
    echo "=== STRUKTUR TABEL DATABASE TEST ===\n\n";
    
    $tables = ['datang2024', 'datang2025', 'pindah2024', 'pindah2025'];
    
    foreach($tables as $table) {
        echo "Struktur tabel '$table':\n";
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($columns as $column) {
            echo "  - " . $column['Field'] . " (" . $column['Type'] . ")" . 
                 ($column['Null'] == 'YES' ? ' NULL' : ' NOT NULL') . 
                 ($column['Key'] == 'PRI' ? ' PRIMARY KEY' : '') . "\n";
        }
        echo "\n";
    }
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>