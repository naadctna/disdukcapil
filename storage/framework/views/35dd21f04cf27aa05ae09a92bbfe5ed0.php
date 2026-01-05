<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelurahan - Sistem Kependudukan</title>
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
        
        .gradient-card {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
            backdrop-filter: blur(10px);
        }

        .dropdown:hover .dropdown-menu {
            display: block;
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
                        <p class="text-xs text-primary-500 font-medium">Data Kelurahan</p>
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
                    
                    <!-- Dropdown Wilayah -->
                    <div class="relative dropdown">
                        <button class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            <span>Wilayah</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 glass rounded-xl shadow-xl overflow-hidden">
                            <a href="<?php echo e(url('/kecamatan')); ?>" class="block px-4 py-3 text-sm text-primary-700 hover:bg-primary-100/50 font-semibold transition-all duration-200">
                                Data Kecamatan
                            </a>
                            <a href="<?php echo e(url('/kelurahan')); ?>" class="block px-4 py-3 text-sm text-primary-700 hover:bg-primary-100/50 font-semibold transition-all duration-200">
                                Data Kelurahan
                            </a>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(url('/upload-excel')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        <span>Upload Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                    Data Kelurahan
                </span>
            </h2>
            <p class="text-gray-600">Daftar kelurahan berdasarkan data perpindahan penduduk</p>
        </div>

        <!-- Search Bar & Filter -->
        <div class="mb-6">
            <form method="GET" action="<?php echo e(url('/kelurahan')); ?>" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="<?php echo e($search ?? ''); ?>" 
                           placeholder="Cari kelurahan atau kecamatan..." 
                           class="w-full px-4 py-3 rounded-xl border border-primary-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200">
                </div>
                <select name="jenis" class="px-4 py-3 rounded-xl border border-primary-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 bg-white">
                    <option value="">Semua Data</option>
                    <option value="datang" <?php echo e(($jenis ?? '') === 'datang' ? 'selected' : ''); ?>>Datang</option>
                    <option value="pindah" <?php echo e(($jenis ?? '') === 'pindah' ? 'selected' : ''); ?>>Pindah</option>
                </select>
                <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                <?php if($search || $jenis): ?>
                <a href="<?php echo e(url('/kelurahan')); ?>" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200">
                    Reset
                </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Data Table -->
        <div class="gradient-card rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-primary-500 to-primary-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Kelurahan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Kecamatan</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Datang</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Pindah</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 divide-y divide-primary-100">
                        <?php $__empty_1 = true; $__currentLoopData = $kelurahan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-primary-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($item['kelurahan']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($item['kecamatan'] ?? '-'); ?></td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <?php echo e(number_format($item['datang'] ?? 0)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <?php echo e(number_format($item['pindah'] ?? 0)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center font-bold text-gray-900"><?php echo e(number_format($item['jumlah'])); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"/>
                                </svg>
                                <p class="text-lg font-semibold">Tidak ada data kelurahan</p>
                                <p class="text-sm">Silakan upload data terlebih dahulu</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        <?php if($kelurahan->count() > 0): ?>
        <div class="mt-6 gradient-card rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-primary-600 font-semibold uppercase tracking-wider">Total Kelurahan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e(number_format($kelurahan->count())); ?></p>
                </div>
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 p-4 rounded-xl shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\Users\muham\disdukcapil\resources\views/kelurahan.blade.php ENDPATH**/ ?>