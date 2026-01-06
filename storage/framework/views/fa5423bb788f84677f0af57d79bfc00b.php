<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Data Penduduk - Disdukcapil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        
        .gradient-card {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
            backdrop-filter: blur(10px);
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Toast Notification Styles */
        @keyframes slideInDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        @keyframes slideOutUp {
            from {
                transform: translate(-50%, 0);
                opacity: 1;
            }
            to {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
        }

        .toast-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            animation: slideInDown 0.5s ease-out;
            min-width: 320px;
            max-width: 500px;
            border-radius: 8px;
        }

        .toast-notification.hiding {
            animation: slideOutUp 0.5s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-primary-50 via-purple-50 to-indigo-100 min-h-screen">
    <!-- Toast Container -->
    <div id="toastContainer"></div>
    
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
                        <p class="text-xs text-primary-500 font-medium">Data Penduduk</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(url('/')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="<?php echo e(url('/penduduk')); ?>" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    
                    <a href="<?php echo e(url('/kecamatan')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span>Wilayah</span>
                    </a>
                    
                    <a href="<?php echo e(url('/upload-excel')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                        </svg>
                        <span>Upload Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-indigo-600/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Data Penduduk Digital
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Kelola dan pantau data perpindahan penduduk datang dan pindah secara real-time
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 relative">

        <!-- Summary Cards -->
        <div class="bg-white rounded-3xl p-8 shadow-lg mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Datang Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">TOTAL DATANG</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1"><?php echo e(number_format($rekapitulasi->total_datang ?? 0)); ?></p>
                            <p class="text-purple-500 text-sm">2024 - 2025</p>
                        </div>
                        <div class="bg-green-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 7l1.41 1.41L5.83 11H16v2H5.83l2.58 2.59L7 17l-5-5z"/>
                                <path d="M20 5h-8V3h8c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2h-8v-2h8V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pindah Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">TOTAL PINDAH</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1"><?php echo e(number_format($rekapitulasi->total_pindah ?? 0)); ?></p>
                            <p class="text-purple-500 text-sm">2024 - 2025</p>
                        </div>
                        <div class="bg-red-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5z"/>
                                <path d="M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Selisih Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">SELISIH</p>
                            <p class="text-4xl font-bold <?php echo e((($rekapitulasi->total_datang ?? 0) - ($rekapitulasi->total_pindah ?? 0)) >= 0 ? 'text-green-600' : 'text-red-600'); ?> mb-1">
                                <?php echo e((($rekapitulasi->total_datang ?? 0) - ($rekapitulasi->total_pindah ?? 0)) >= 0 ? '+' : ''); ?><?php echo e(number_format(($rekapitulasi->total_datang ?? 0) - ($rekapitulasi->total_pindah ?? 0))); ?>

                            </p>
                            <p class="text-purple-500 text-sm"><?php echo e((($rekapitulasi->total_datang ?? 0) - ($rekapitulasi->total_pindah ?? 0)) >= 0 ? 'Surplus' : 'Defisit'); ?></p>
                        </div>
                        <div class="bg-green-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 14l5-5 5 5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tahun Aktif Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">TAHUN AKTIF</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1"><?php echo e(date('Y')); ?></p>
                            <p class="text-purple-500 text-sm">Data Terkini</p>
                        </div>
                        <div class="bg-amber-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                Pencarian & Filter
            </h3>
            <form method="GET" action="<?php echo e(route('penduduk')); ?>" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pencarian</label>
                        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Cari nama, NIK..." class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Status</option>
                            <option value="datang" <?php echo e(($status ?? '') === 'datang' ? 'selected' : ''); ?>>Datang</option>
                            <option value="pindah" <?php echo e(($status ?? '') === 'pindah' ? 'selected' : ''); ?>>Pindah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <select name="tahun" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Tahun</option>
                            <?php
                                $currentYear = date('Y');
                                $startYear = 2020;
                                $endYear = $currentYear + 5;
                                $selectedTahun = $tahun ?? '';
                            ?>
                            <?php for($year = $endYear; $year >= $startYear; $year--): ?>
                                <option value="<?php echo e($year); ?>" <?php echo e($selectedTahun == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <select name="bulan" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Bulan</option>
                            <?php
                                $months = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                $selectedBulan = $bulan ?? '';
                            ?>
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e($selectedBulan == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                            </svg>
                            <span>Filter</span>
                        </button>
                        <?php if($search || $status || $tahun || ($bulan ?? '')): ?>
                        <button type="button" onclick="clearFilters()" class="bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="gradient-card rounded-2xl border border-white/20 shadow-xl overflow-hidden">
            <div class="p-6 border-b border-white/10">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                            </svg>
                            Daftar Penduduk
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">Kelola dan lihat data penduduk</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-primary-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Jenis Data</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $penduduk ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-primary-50/50 transition-colors duration-200" id="row-<?php echo e($p->table_source); ?>-<?php echo e($p->id); ?>">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium"><?php echo e($p->nama ?? '-'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"><?php echo e($p->alamat ?? '-'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if(isset($p->tanggal) && $p->tanggal && $p->tanggal !== '-'): ?>
                                    <?php echo e(\Carbon\Carbon::parse($p->tanggal)->format('d/m/Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e(str_contains($p->jenis_data, 'Datang') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($p->jenis_data ?? '-'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="relative inline-block text-left action-dropdown">
                                    <button onclick="toggleDropdown(event, <?php echo e($index); ?>)" class="text-gray-600 hover:text-primary-600 p-2 rounded-lg hover:bg-primary-50 transition-all duration-200">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-<?php echo e($index); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl z-50 border border-gray-100 overflow-hidden">
                                        <button onclick="viewDetail('<?php echo e($p->table_source ?? (str_contains($p->jenis_data, 'Datang') ? (str_contains($p->jenis_data, '2024') ? 'datang2024' : 'datang2025') : (str_contains($p->jenis_data, '2024') ? 'pindah2024' : 'pindah2025'))); ?>', <?php echo e($p->id); ?>)" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center space-x-2">
                                            <i class="fas fa-eye w-4"></i>
                                            <span>Lihat Detail</span>
                                        </button>
                                        <button onclick="confirmDelete('<?php echo e($p->table_source ?? (str_contains($p->jenis_data, 'Datang') ? (str_contains($p->jenis_data, '2024') ? 'datang2024' : 'datang2025') : (str_contains($p->jenis_data, '2024') ? 'pindah2024' : 'pindah2025'))); ?>', <?php echo e($p->id); ?>, '<?php echo e($p->nama); ?>')" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 flex items-center space-x-2 border-t border-gray-100">
                                            <i class="fas fa-trash w-4"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <div class="bg-gradient-to-r from-primary-100 to-purple-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-users text-4xl text-primary-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada data</h3>
                                    <p class="text-sm">Mulai dengan menambah data penduduk atau import dari Excel</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Data -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Detail Data Penduduk</h3>
                        <button onclick="closeDetailModal()" class="text-white hover:text-gray-200 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                    <div id="detailContent" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Content akan diisi via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter form handlers
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const form = document.getElementById('filterForm');
            
            // Submit saat enter di search
            searchInput?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    form.submit();
                }
            });
            
            // Clear button functionality
            window.clearFilters = function() {
                window.location.href = '<?php echo e(route("penduduk")); ?>';
            };
        });
        
        // View Detail Functions
        function viewDetail(table, id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
            
            // Show loading
            content.innerHTML = '<div class="col-span-2 text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-primary-500"></i><p class="mt-2 text-gray-600">Memuat data...</p></div>';
            modal.classList.remove('hidden');
            
            // Fetch detail data
            fetch(`/penduduk/detail/${table}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayDetailData(data.data, table, data.fieldLabels);
                    } else {
                        content.innerHTML = '<div class="col-span-2 text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl"></i><p class="mt-2">Data tidak ditemukan</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = '<div class="col-span-2 text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl"></i><p class="mt-2">Terjadi kesalahan saat memuat data</p></div>';
                });
        }
        
        function displayDetailData(data, table, fieldLabels = {}) {
            const content = document.getElementById('detailContent');
            let html = '';
            
            // Define field groups untuk tampilan yang lebih terorganisir
            const fieldGroups = {
                'Data Utama': ['id', 'nik', 'no_kk', 'nama_lengkap', 'no_datang', 'tgl_datang', 'tanggal_datang', 'klasifikasi_pindah'],
                'Alamat Asal': ['no_prop_asal', 'nama_prop_asal', 'no_kab_asal', 'nama_kab_asal', 'no_kec_asal', 'nama_kec_asal', 'no_kel_asal', 'nama_kel_asal', 'alamat_asal', 'no_rt_asal', 'no_rw_asal'],
                'Alamat Tujuan': ['no_prop_tujuan', 'nama_prop_tujuan', 'no_kab_tujuan', 'nama_kab_tujuan', 'no_kec_tujuan', 'nama_kec_tujuan', 'no_kel_tujuan', 'nama_kel_tujuan', 'alamat_tujuan', 'no_rt_tujuan', 'no_rw_tujuan'],
                'Informasi Sistem': ['kode', 'nama', 'alamat', 'created_at', 'updated_at']
            };
            
            // Use field labels from API response (centralized service)
            const defaultFieldLabels = {
                'id': 'ID',
                'nik': 'NIK', 
                'no_kk': 'No. KK',
                'nama_lengkap': 'Nama Lengkap',
                'no_datang': 'No. Datang',
                'tgl_datang': 'Tanggal Datang',
                'klasifikasi_pindah': 'Klasifikasi Pindah',
                'no_prop_asal': 'Kode Provinsi Asal',
                'nama_prop_asal': 'Nama Provinsi Asal',
                'no_kab_asal': 'Kode Kabupaten Asal',
                'nama_kab_asal': 'Nama Kabupaten Asal',
                'no_kec_asal': 'Kode Kecamatan Asal',
                'nama_kec_asal': 'Nama Kecamatan Asal',
                'no_kel_asal': 'Kode Kelurahan Asal',
                'nama_kel_asal': 'Nama Kelurahan Asal',
                'alamat_asal': 'Alamat Lengkap Asal',
                'no_rt_asal': 'No. RT Asal',
                'no_rw_asal': 'No. RW Asal',
                'no_prop_tujuan': 'Kode Provinsi Tujuan',
                'nama_prop_tujuan': 'Nama Provinsi Tujuan',
                'no_kab_tujuan': 'Kode Kabupaten Tujuan',
                'nama_kab_tujuan': 'Nama Kabupaten Tujuan',
                'no_kec_tujuan': 'Kode Kecamatan Tujuan',
                'nama_kec_tujuan': 'Nama Kecamatan Tujuan',
                'no_kel_tujuan': 'Kode Kelurahan Tujuan',
                'nama_kel_tujuan': 'Nama Kelurahan Tujuan',
                'alamat_tujuan': 'Alamat Lengkap Tujuan',
                'no_rt_tujuan': 'No. RT Tujuan',
                'no_rw_tujuan': 'No. RW Tujuan',
                'kode': 'Kode Referensi',
                'created_at': 'Dibuat',
                'updated_at': 'Diperbarui'
            };
            
            // Merge provided fieldLabels with defaults
            const labels = {...defaultFieldLabels, ...fieldLabels};
            
            // Sort fields untuk display yang lebih teratur (29 kolom Excel)
            const sortedFields = Object.keys(data).sort((a, b) => {
                const order = [
                    'id', 'nik', 'no_kk', 'nama_lengkap', 'no_datang', 'tgl_datang', 'tanggal_datang', 'klasifikasi_pindah',
                    'no_prop_asal', 'nama_prop_asal', 'no_kab_asal', 'nama_kab_asal', 'no_kec_asal', 'nama_kec_asal',
                    'no_kel_asal', 'nama_kel_asal', 'alamat_asal', 'no_rt_asal', 'no_rw_asal',
                    'no_prop_tujuan', 'nama_prop_tujuan', 'no_kab_tujuan', 'nama_kab_tujuan', 'no_kec_tujuan', 'nama_kec_tujuan',
                    'no_kel_tujuan', 'nama_kel_tujuan', 'alamat_tujuan', 'no_rt_tujuan', 'no_rw_tujuan', 'kode'
                ];
                const aIndex = order.indexOf(a);
                const bIndex = order.indexOf(b);
                if (aIndex !== -1 && bIndex !== -1) return aIndex - bIndex;
                if (aIndex !== -1) return -1;
                if (bIndex !== -1) return 1;
                return a.localeCompare(b);
            });
            
            // Display fields by groups untuk tampilan yang lebih rapi
            Object.keys(fieldGroups).forEach(groupName => {
                const fieldsInGroup = fieldGroups[groupName].filter(field => 
                    data.hasOwnProperty(field) && data[field] !== null && data[field] !== undefined && data[field] !== ''
                );
                
                if (fieldsInGroup.length > 0) {
                    html += `
                        <div class="col-span-2 mb-4">
                            <h4 class="text-lg font-bold text-primary-600 border-b-2 border-primary-200 pb-2 mb-3">${groupName}</h4>
                        </div>
                    `;
                    
                    fieldsInGroup.forEach(field => {
                        const label = labels[field] || field.charAt(0).toUpperCase() + field.slice(1).replace(/_/g, ' ');
                        const value = data[field] || '-';
                        
                        html += `
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">${label}</label>
                                <div class="text-gray-900 bg-white rounded px-3 py-2 border">${value}</div>
                            </div>
                        `;
                    });
                }
            });
            
            content.innerHTML = html;
        }
        
        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }



        // Confirm Delete Function
        function confirmDelete(table, id, nama) {
            // Set data untuk modal delete
            document.getElementById('deleteModalName').textContent = nama;
            document.getElementById('confirmDeleteBtn').onclick = function() {
                closeDeleteModal();
                deleteData(table, id);
            };
            
            // Show modal
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Close Delete Modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Delete Data Function
        function deleteData(table, id) {
            // Show loading
            const loadingHTML = '<div id="deleteLoading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"><div class="bg-white p-6 rounded-lg"><i class="fas fa-spinner fa-spin text-2xl text-primary-500"></i><p class="mt-2">Menghapus data...</p></div></div>';
            document.body.insertAdjacentHTML('beforeend', loadingHTML);

            // CSRF Token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/penduduk/delete/${table}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                // Remove loading
                const loadingEl = document.getElementById('deleteLoading');
                if (loadingEl) loadingEl.remove();
                
                if (data.success) {
                    showToast('success', 'Data berhasil dihapus!');
                    
                    // Hapus row dari tabel tanpa refresh
                    const row = document.getElementById(`row-${table}-${id}`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease-out';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(() => {
                            row.remove();
                            // Update nomor urut
                            updateRowNumbers();
                        }, 300);
                    }
                } else {
                    showToast('error', 'Gagal menghapus data: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                // Remove loading
                const loadingEl = document.getElementById('deleteLoading');
                if (loadingEl) loadingEl.remove();
                
                console.error('Error:', error);
                showToast('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
            });
        }

        // Update row numbers after delete
        function updateRowNumbers() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.textContent = index + 1;
                }
            });
        }
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus</h3>
                        <p class="text-gray-600">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <p class="text-gray-700 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data <span class="font-semibold text-gray-900" id="deleteModalName"></span>?
                    </p>
                    <div class="mt-3 p-3 bg-red-50 border-l-4 border-red-400 rounded">
                        <p class="text-red-700 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Data yang dihapus akan hilang permanen dari database dan tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-xl font-medium hover:bg-gray-300 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button id="confirmDeleteBtn"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Hapus Data
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Toast notification function
        function showToast(type, message) {
            const toastId = 'toast-' + Date.now();
            const bgColor = type === 'success' ? '#10b981' : '#ef4444';
            const icon = type === 'success' 
                ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
            const title = type === 'success' ? 'Berhasil!' : 'Gagal!';
            
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'toast-notification';
            toast.style.backgroundColor = bgColor;
            toast.innerHTML = `
                <div class="p-4 flex items-center space-x-3 text-white">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        ${icon}
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium">${title}</p>
                        <p class="text-sm opacity-90">${message}</p>
                    </div>
                    <button onclick="closeToast('${toastId}')" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
            
            const container = document.getElementById('toastContainer');
            container.appendChild(toast);
            
            // Auto dismiss after 3 seconds
            setTimeout(() => {
                closeToast(toastId);
            }, 3000);
        }
        
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }

        // Toggle Dropdown Function
        function toggleDropdown(event, index) {
            event.stopPropagation();
            const dropdown = document.getElementById(`dropdown-${index}`);
            
            // Close all other dropdowns
            document.querySelectorAll('.action-dropdown > div').forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.action-dropdown')) {
                document.querySelectorAll('.action-dropdown > div').forEach(dd => {
                    dd.classList.add('hidden');
                });
            }
        });
    </script>

</body>
</html>
<?php /**PATH D:\laragon\www\disdukcapil\resources\views/penduduk.blade.php ENDPATH**/ ?>