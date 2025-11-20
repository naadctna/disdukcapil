<?php
// Test upload through ExcelUploadController
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\ExcelUploadController;

try {
    // Create mock uploaded file
    $filePath = 'test_datang_2025.csv';
    
    // Create a temporary uploaded file object
    $uploadedFile = new UploadedFile(
        $filePath,
        'test_datang_2025.csv',
        'text/csv',
        null,
        true // test mode
    );
    
    // Create mock request
    $request = new Request();
    $request->files->set('excel_file', $uploadedFile);
    $request->request->set('data_type', 'datang');
    
    // Create controller and test upload
    $controller = new ExcelUploadController();
    $response = $controller->processUpload($request);
    
    // Check response
    if ($response->getStatusCode() == 302) {
        echo "Upload successful! Redirected.\n";
    } else {
        echo "Upload response status: " . $response->getStatusCode() . "\n";
        echo "Response content: " . $response->getContent() . "\n";
    }
    
    // Check database
    $count = DB::table('datang2025')->count();
    echo "Records in datang2025: $count\n";
    
    if ($count > 0) {
        $sample = DB::table('datang2025')->first();
        echo "Sample record:\n";
        echo "- nama_lengkap: " . ($sample->nama_lengkap ?? 'null') . "\n";
        echo "- no_prop_asal: " . ($sample->no_prop_asal ?? 'null') . "\n";
        echo "- nama_prop_asal: " . ($sample->nama_prop_asal ?? 'null') . "\n";
        echo "- alamat_asal: " . ($sample->alamat_asal ?? 'null') . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>