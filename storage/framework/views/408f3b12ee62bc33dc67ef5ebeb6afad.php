<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data CSV - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7c3aed',
                            800: '#6b21a8',
                            900: '#581c87'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .form-input {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .form-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
        }

        .drag-drop-zone {
            transition: all 0.3s ease;
        }

        .drag-drop-zone.dragover {
            background: rgba(168, 85, 247, 0.1);
            border-color: #9333ea;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-purple-50 to-indigo-100 min-h-screen">
    <!-- Navbar -->
    <nav class="glass shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                            Sistem Informasi Kependudukan
                        </h1>
                        <p class="text-xs text-primary-500 font-medium">CSV Upload</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(url('/')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="<?php echo e(url('/rekapitulasi')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        <span>Rekapitulasi</span>
                    </a>
                    <a href="<?php echo e(url('/penduduk')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    <a href="<?php echo e(url('/upload-excel')); ?>" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <polyline points="14,2 14,8 20,8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10,9 9,9 8,9"/>
                        </svg>
                        <span>Upload Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 via-purple-500/10 to-indigo-600/10"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/5 to-white/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-6 relative">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                    </svg>
                    Import Data
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Upload Data Excel
                    </span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Upload file Excel untuk import data penduduk datang dan pindah secara bulk
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        <!-- Alerts -->
        <?php if(session('success')): ?>
        <div class="mb-12 glass rounded-2xl p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-green-800 font-semibold"><?php echo e(session('success')); ?></div>
            </div>
            
            <?php if(session('upload_results')): ?>
                <?php $results = session('upload_results'); ?>
                <div class="mt-4 p-4 bg-green-50 rounded-xl">
                    <h4 class="font-semibold text-green-800 mb-2">Ringkasan Upload:</h4>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-sm">
                            <span class="font-medium">Data Berhasil:</span>
                            <span class="text-green-600 font-bold"><?php echo e($results['inserted']); ?></span>
                        </div>
                        <div class="text-sm">
                            <span class="font-medium">Error:</span>
                            <span class="text-red-600 font-bold"><?php echo e($results['errors']); ?></span>
                        </div>
                    </div>
                    
                    <?php if(!empty($results['preview'])): ?>
                        <h5 class="font-medium text-green-800 mb-2">Preview Data:</h5>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="bg-green-100">
                                        <?php if(!empty($results['preview'][0])): ?>
                                            <?php $__currentLoopData = array_keys($results['preview'][0]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th class="px-3 py-2 text-left font-medium text-green-800"><?php echo e($key); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $results['preview']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-green-200">
                                            <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="px-3 py-2 text-gray-700"><?php echo e($value); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="mb-12 glass rounded-2xl p-6 border-l-4 border-red-500">
            <div class="flex items-start">
                <div class="bg-red-100 p-2 rounded-full mr-3 mt-1">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </div>
                <div class="text-red-800 font-medium flex-1"><?php echo session('error'); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="mb-12 glass rounded-2xl p-6 border-l-4 border-red-500">
            <div class="flex items-center mb-3">
                <div class="bg-red-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </div>
                <div class="text-red-800 font-medium">Validation Errors:</div>
            </div>
            <ul class="list-disc list-inside text-red-700 space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Upload Form -->
        <div class="glass rounded-2xl p-8 shadow-xl mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Upload File Excel</h3>
                    <p class="text-sm text-gray-500">Pilih file Excel (.csv, .xlsx, .xls) untuk import data</p>
                </div>
            </div>

            <!-- Download Template -->
            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                <h4 class="font-bold text-blue-800 mb-3">📥 Download Template CSV</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="<?php echo e(url('/template_penduduk_datang.csv')); ?>" download class="flex items-center justify-center px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <path d="M14 2v6h6M9 15l3 3m0 0l3-3m-3 3V9"/>
                        </svg>
                        Template Penduduk Datang
                    </a>
                    <a href="<?php echo e(url('/template_penduduk_pindah.csv')); ?>" download class="flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <path d="M14 2v6h6M9 15l3 3m0 0l3-3m-3 3V9"/>
                        </svg>
                        Template Penduduk Pindah
                    </a>
                </div>
                <p class="text-sm text-blue-600 mt-2">💡 Download template ini, isi dengan data Anda, dan upload kembali!</p>
            </div>

            <form action="<?php echo e(url('/upload-excel/process')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                <?php echo csrf_field(); ?>
                
                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        </svg>
                        File Excel
                    </label>
                    <div class="drag-drop-zone border-2 border-dashed border-primary-300 rounded-xl p-8 text-center">
                        <input type="file" name="excel_file" id="excel_file" accept=".csv,.xlsx,.xls" required class="hidden">
                        <div id="drop-area">
                            <svg class="w-12 h-12 mx-auto text-primary-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <polyline points="14,2 14,8 20,8"/>
                            </svg>
                            <p class="text-gray-600 mb-2">Drag & drop file Excel di sini atau</p>
                            <button type="button" onclick="document.getElementById('excel_file').click()" class="text-primary-600 hover:text-primary-700 font-semibold">
                                Klik untuk pilih file
                            </button>
                            <p class="text-xs text-gray-500 mt-2">Format: CSV, XLSX, XLS (Max: 10MB)</p>
                        </div>
                        <div id="file-info" class="hidden">
                            <p class="text-green-600 font-medium">File dipilih:</p>
                            <p id="file-name" class="text-sm text-gray-600"></p>
                        </div>
                    </div>
                </div>

                <!-- Data Type & Year -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Jenis Data
                        </label>
                        <select name="data_type" required class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500">
                            <option value="">Pilih jenis data</option>
                            <option value="datang">Data Penduduk Datang</option>
                            <option value="pindah">Data Penduduk Pindah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                            </svg>
                            Tahun
                        </label>
                        <select name="year" required class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500">
                            <option value="">Pilih tahun</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-4 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-shadow duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    <span>Upload & Proses Data</span>
                </button>
            </form>
        </div>

        <!-- Format Excel Guidelines -->
        <div class="glass rounded-2xl p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📋 Format File Excel</h3>
            <p class="text-sm text-gray-600 mb-6">Pastikan file Excel Anda menggunakan format kolom yang benar:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Format Penduduk Datang -->
                <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                        <h4 class="font-bold text-green-800">Data Penduduk Datang</h4>
                    </div>
                    <div class="space-y-2">
                        <div class="bg-white p-3 rounded-lg border-l-4 border-green-500">
                            <p class="font-semibold text-gray-700">Kolom A: Nama</p>
                            <p class="text-sm text-gray-600">Contoh: "John Doe"</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border-l-4 border-green-500">
                            <p class="font-semibold text-gray-700">Kolom B: Alamat</p>
                            <p class="text-sm text-gray-600">Contoh: "Jl. Merdeka No. 123"</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border-l-4 border-green-500">
                            <p class="font-semibold text-gray-700">Kolom C: Tanggal Datang</p>
                            <p class="text-sm text-gray-600">Format: YYYY-MM-DD<br>Contoh: "2025-01-15"</p>
                        </div>
                    </div>
                </div>
                
                <!-- Format Penduduk Pindah -->
                <div class="bg-red-50 border border-red-200 rounded-xl p-5">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-red-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                        <h4 class="font-bold text-red-800">Data Penduduk Pindah</h4>
                    </div>
                    <div class="space-y-2">
                        <div class="bg-white p-3 rounded-lg border-l-4 border-red-500">
                            <p class="font-semibold text-gray-700">Kolom A: Nama</p>
                            <p class="text-sm text-gray-600">Contoh: "Jane Smith"</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border-l-4 border-red-500">
                            <p class="font-semibold text-gray-700">Kolom B: Alamat Asal</p>
                            <p class="text-sm text-gray-600">Contoh: "Jl. Sudirman No. 456"</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border-l-4 border-red-500">
                            <p class="font-semibold text-gray-700">Kolom C: Alamat Tujuan</p>
                            <p class="text-sm text-gray-600">Contoh: "Jl. Thamrin No. 789"</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border-l-4 border-red-500">
                            <p class="font-semibold text-gray-700">Kolom D: Tanggal Pindah</p>
                            <p class="text-sm text-gray-600">Format: YYYY-MM-DD<br>Contoh: "2025-01-20"</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Format Flexibility -->
            <div class="mt-6 bg-purple-50 border border-purple-200 rounded-xl p-4">
                <h5 class="font-bold text-purple-800 mb-2">✨ Format Kolom Fleksibel:</h5>
                <div class="text-sm text-purple-700 space-y-2">
                    <p><strong>Nama kolom bisa menggunakan:</strong></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                        <div>
                            <p class="font-semibold">✅ Spasi:</p>
                            <p class="text-xs">"tanggal datang", "alamat asal", "alamat tujuan"</p>
                        </div>
                        <div>
                            <p class="font-semibold">✅ Underscore:</p>
                            <p class="text-xs">"tanggal_datang", "alamat_asal", "alamat_tujuan"</p>
                        </div>
                        <div>
                            <p class="font-semibold">✅ Huruf besar:</p>
                            <p class="text-xs">"NAMA", "ALAMAT", "TANGGAL_DATANG"</p>
                        </div>
                        <div>
                            <p class="font-semibold">✅ Huruf kecil:</p>
                            <p class="text-xs">"nama", "alamat", "tanggal_datang"</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Important Notes -->
            <!-- Cara Convert Excel ke CSV -->
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <h5 class="font-bold text-yellow-800 mb-2">📝 Cara Convert Excel ke CSV:</h5>
                <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                    <li>Buka file Excel Anda</li>
                    <li>Klik <strong>File</strong> → <strong>Save As</strong></li>
                    <li>Pada "Save as type", pilih <strong>CSV (Comma delimited) (*.csv)</strong></li>
                    <li>Klik <strong>Save</strong></li>
                    <li>Upload file .csv yang sudah diconvert</li>
                </ol>
            </div>
            
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4">
                <h5 class="font-bold text-blue-800 mb-2">⚠️ Catatan Penting:</h5>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Pastikan kolom pertama (baris 1) berisi header/judul kolom</li>
                    <li>• Data mulai dari baris kedua</li>
                    <li>• Format tanggal: YYYY-MM-DD (contoh: 2025-01-15)</li>
                    <li>• <strong>File harus berformat .csv saja</strong></li>
                    <li>• Maksimal ukuran file 10MB</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // File upload handling
        const fileInput = document.getElementById('excel_file');
        const dropArea = document.getElementById('drop-area');
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        const dragDropZone = document.querySelector('.drag-drop-zone');

        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                dropArea.classList.add('hidden');
                fileInfo.classList.remove('hidden');
                fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Drag and drop functionality
        dragDropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dragDropZone.classList.add('dragover');
        });

        dragDropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dragDropZone.classList.remove('dragover');
        });

        dragDropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dragDropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect({target: {files: files}});
            }
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\disdukcapil\resources\views/upload-excel.blade.php ENDPATH**/ ?>