<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

DB::table('migrations')->insert([
    'migration' => '2025_11_19_040502_extend_rt_rw_columns_size',
    'batch' => 4
]);
echo "Migration marked as completed.\n";