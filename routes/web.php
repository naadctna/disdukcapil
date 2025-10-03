<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelUploadController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi']);
Route::get('/penduduk', [DashboardController::class, 'penduduk']);

// Routes untuk tambah data manual (optional - bisa dihapus nanti)
Route::post('/tambah-datang', [DashboardController::class, 'tambahDatang']);
Route::post('/tambah-pindah', [DashboardController::class, 'tambahPindah']);

// Routes untuk Excel Upload
Route::get('/upload-excel', [ExcelUploadController::class, 'uploadForm']);
Route::post('/upload-excel/process', [ExcelUploadController::class, 'processUpload']);
Route::get('/upload-excel/template', [ExcelUploadController::class, 'downloadTemplate']);
