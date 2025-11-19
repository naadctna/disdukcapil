<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$count = DB::table('datang2025')->count();
echo "Records in datang2025: {$count}\n";

if ($count > 0) {
    $records = DB::table('datang2025')->orderBy('id', 'desc')->limit(3)->get();
    foreach ($records as $record) {
        echo "ID: {$record->id} - Nama: {$record->nama_lengkap} - Alamat Asal: {$record->alamat_asal}\n";
    }
}