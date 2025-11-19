<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Test upload endpoint
Route::get('/test-upload', function () {
    $filePath = public_path('test_upload_pindah2024.csv');
    
    if (!file_exists($filePath)) {
        return 'File test tidak ditemukan!';
    }
    
    // Simulate file upload
    $file = new \Illuminate\Http\UploadedFile(
        $filePath,
        'test_upload_pindah2024.csv',
        'text/csv',
        null,
        true
    );
    
    $controller = new \App\Http\Controllers\ExcelUploadController();
    
    try {
        $result = $controller->processExcelFile($file, 'pindah2024', 'pindah', 2024);
        
        return response()->json([
            'status' => 'success',
            'result' => $result
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});