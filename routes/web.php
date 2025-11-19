<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelUploadController;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi'])->name('rekapitulasi');
Route::get('/penduduk', [DashboardController::class, 'penduduk'])->name('penduduk');

// Routes untuk Excel Upload
Route::get('/upload-excel', [ExcelUploadController::class, 'uploadForm'])->name('upload.form');
Route::post('/upload-excel/process', [ExcelUploadController::class, 'processUpload'])->name('upload.process');

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

// Routes untuk Edit & Delete Data
Route::put('/penduduk/update/{table}/{id}', [DashboardController::class, 'updateData'])->name('penduduk.update');
Route::delete('/penduduk/delete/{table}/{id}', [DashboardController::class, 'deleteData'])->name('penduduk.delete');
Route::get('/penduduk/detail/{table}/{id}', [DashboardController::class, 'viewDetail'])->name('penduduk.detail');
