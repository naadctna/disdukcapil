<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking table structure for pindah2025:\n\n";

$columns = DB::select('DESCRIBE pindah2025');
foreach($columns as $col) {
    $nullable = $col->Null === 'YES' ? 'NULL' : 'NOT NULL';
    $default = $col->Default !== null ? "DEFAULT '{$col->Default}'" : 'NO DEFAULT';
    echo "- {$col->Field} | {$col->Type} | {$nullable} | {$default}\n";
}
?>