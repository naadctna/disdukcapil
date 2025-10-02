<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/rekapitulasi', [DashboardController::class, 'rekapitulasi']);
Route::get('/penduduk', [DashboardController::class, 'penduduk']);

// Routes untuk tambah data
Route::post('/tambah-datang', [DashboardController::class, 'tambahDatang']);
Route::post('/tambah-pindah', [DashboardController::class, 'tambahPindah']);
