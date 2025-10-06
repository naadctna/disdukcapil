<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelUploadController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi']);
Route::get('/penduduk', [DashboardController::class, 'penduduk']);

// Routes untuk Excel Upload
Route::get('/upload-excel', [ExcelUploadController::class, 'uploadForm']);
Route::post('/upload-excel/process', [ExcelUploadController::class, 'processUpload']);

// Routes untuk Edit & Delete Data
Route::put('/penduduk/update/{table}/{id}', [DashboardController::class, 'updateData']);
Route::delete('/penduduk/delete/{table}/{id}', [DashboardController::class, 'deleteData']);
