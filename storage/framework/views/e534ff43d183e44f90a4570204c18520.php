<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Data Penduduk - Sistem Kependudukan</title>
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

        .data-table {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        /* Enhanced Search Animations */
        @keyframes searchPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes slideInUp {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        @keyframes fadeInScale {
            from { 
                opacity: 0; 
                transform: scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: scale(1); 
            }
        }
        
        .search-container {
            animation: slideInUp 0.6s ease-out;
        }
        
        .search-result {
            animation: fadeInScale 0.4s ease-out;
        }
        
        .search-icon:hover {
            animation: searchPulse 1s infinite;
        }
        
        .no-data-container {
            animation: fadeInScale 0.5s ease-out;
        }
        
        /* Hover effects for search suggestions */
        .search-suggestion:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Input focus animation */
        .search-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(168, 85, 247, 0.2);
        }



        .loading-spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-left: 3px solid white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                        <p class="text-xs text-primary-500 font-medium">Data Management</p>
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
                    <a href="<?php echo e(url('/penduduk')); ?>" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
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

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 via-purple-500/10 to-indigo-600/10"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/5 to-white/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Manajemen Data
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Data Penduduk
                    </span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Input, kelola, dan pantau data pergerakan penduduk dengan interface yang mudah digunakan
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        
        <!-- Enhanced Search Bar -->
        <div class="mb-8 search-container">
            <div class="relative">
                <!-- Background with animated gradient -->
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 rounded-3xl blur-sm opacity-30 animate-pulse"></div>
                
                <!-- Main search container -->
                <div class="relative glass rounded-3xl p-8 shadow-2xl border border-white/20 backdrop-blur-xl">
                    <!-- Header Section -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-4 rounded-2xl shadow-xl mr-4 transform hover:scale-105 transition-transform duration-200 search-icon">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    Pencarian Data Penduduk
                                </h3>
                                <p class="text-sm text-gray-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                    Cari berdasarkan nama lengkap penduduk
                                </p>
                            </div>
                        </div>
                        
                        <!-- Search Stats -->
                        <?php if($search ?? false): ?>
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 px-4 py-2 rounded-full border border-green-200">
                            <span class="text-sm font-semibold text-green-700 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mode Pencarian Aktif
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(url('/penduduk')); ?>" class="space-y-4">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <!-- Search Input Container -->
                            <div class="flex-1 relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-200 to-pink-200 rounded-2xl blur opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           value="<?php echo e($search ?? ''); ?>"
                                           placeholder="Ketik nama penduduk yang ingin dicari..." 
                                           class="search-input relative w-full pl-12 pr-4 py-4 bg-white/90 backdrop-blur-sm rounded-2xl border border-white/30 focus:border-purple-300 focus:ring-2 focus:ring-purple-200 transition-all duration-300 text-gray-800 placeholder-gray-400 shadow-lg hover:shadow-xl font-medium"
                                           autocomplete="off"
                                           spellcheck="false">
                                    
                                    <!-- Clear button for input -->
                                    <?php if($search ?? false): ?>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="document.querySelector('input[name=search]').value=''" 
                                                class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <!-- Search Button -->
                                <button type="submit" 
                                        class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center space-x-3 transform hover:scale-105 active:scale-95 group">
                                    <svg class="w-5 h-5 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span>Cari Data</span>
                                </button>
                                
                                <!-- Reset Button -->
                                <?php if($search ?? false): ?>
                                    <a href="<?php echo e(url('/penduduk')); ?>" 
                                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center space-x-2 transform hover:scale-105 active:scale-95 group">
                                        <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <span>Reset</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Quick Search Suggestions -->
                        <?php if(!($search ?? false)): ?>
                        <div class="mt-4 pt-4 border-t border-white/20">
                            <p class="text-sm text-gray-600 mb-2 font-medium">Pencarian Cepat:</p>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="document.querySelector('input[name=search]').value='Ahmad'" 
                                        class="search-suggestion px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-full text-sm font-medium transition-all duration-200 border border-purple-200">
                                    Ahmad
                                </button>
                                <button type="button" onclick="document.querySelector('input[name=search]').value='Siti'" 
                                        class="search-suggestion px-3 py-1 bg-pink-100 hover:bg-pink-200 text-pink-700 rounded-full text-sm font-medium transition-all duration-200 border border-pink-200">
                                    Siti
                                </button>
                                <button type="button" onclick="document.querySelector('input[name=search]').value='Budi'" 
                                        class="search-suggestion px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full text-sm font-medium transition-all duration-200 border border-blue-200">
                                    Budi
                                </button>
                                <button type="button" onclick="document.querySelector('input[name=search]').value='Dewi'" 
                                        class="search-suggestion px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded-full text-sm font-medium transition-all duration-200 border border-green-200">
                                    Dewi
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                
                <?php if($search ?? false): ?>
                    <!-- Enhanced Search Results Indicator -->
                    <div class="mt-6 relative search-result">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 rounded-2xl blur opacity-50"></div>
                        <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-white/40 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-2 rounded-xl mr-3 animate-pulse">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700 flex items-center">
                                            <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                                Hasil Pencarian Aktif
                                            </span>
                                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                LIVE
                                            </span>
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            Menampilkan data untuk: 
                                            <span class="font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                                "<?php echo e($search); ?>"
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Quick Actions -->
                                <div class="flex gap-2">
                                    <a href="<?php echo e(url('/penduduk')); ?>" 
                                       class="bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span>Hapus Filter</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Success Alert -->
        <?php if(session('success')): ?>
        <div class="mb-8 glass rounded-2xl p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-green-800 font-medium"><?php echo e(session('success')); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16 mt-12">
            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Datang 2024</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(count($datang2024)); ?></p>
                        <p class="text-xs text-green-600 font-semibold">📈 Active Records</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Datang 2025</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(count($datang2025)); ?></p>
                        <p class="text-xs text-green-600 font-semibold">📈 Current Year</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Pindah 2024</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(count($pindah2024)); ?></p>
                        <p class="text-xs text-red-600 font-semibold">📉 Archived</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-400 to-red-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Pindah 2025</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e(count($pindah2025)); ?></p>
                        <p class="text-xs text-red-600 font-semibold">📉 Current Year</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Data Tables -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM3 16a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Database Records</h2>
                    <p class="text-sm text-gray-600">View dan kelola data penduduk yang tersimpan</p>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="space-y-8">
            <!-- Data Datang Section -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl shadow-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Data Penduduk Datang</h3>
                            <p class="text-sm text-gray-500">
                                <?php echo e(count($datang2024) + count($datang2025)); ?> total records
                                <?php if($search ?? false): ?>
                                    <span class="text-blue-600 font-medium">(hasil pencarian: "<?php echo e($search); ?>")</span>
                                <?php else: ?>
                                    (showing recent 100 per table)
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 bg-white/50 px-3 py-1 rounded-full">
                        Live Data
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Datang 2024 -->
                    <div class="glass rounded-2xl p-6 shadow-xl border border-blue-200/30">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-blue-400 to-blue-500 p-2 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900">Data Tahun 2024</h4>
                            </div>
                            <span class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm"><?php echo e(count($datang2024)); ?> records</span>
                        </div>
                        <?php if(count($datang2024) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b-2 border-blue-200">
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider rounded-tl-lg">Nama Lengkap</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Alamat Tujuan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Tanggal Datang</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-blue-700 uppercase tracking-wider rounded-tr-lg w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100">
                                        <?php $__currentLoopData = $datang2024; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900"><?php echo e($data->nama ?? '-'); ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat ?? '-', 35)); ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?php echo e($data->tanggal_datang ?? '-'); ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="relative inline-block text-left">
                                                    <button type="button" class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition-colors" onclick="toggleDropdown('dropdown-datang2024-<?php echo e($data->id); ?>')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 6a2 2 0 110-4 2 2 0 010 4zM12 14a2 2 0 110-4 2 2 0 010 4zM12 22a2 2 0 110-4 2 2 0 010 4z"/>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdown-datang2024-<?php echo e($data->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                                        <div class="py-1">
                                                            <button onclick="editData('datang2024', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>', '<?php echo e($data->alamat); ?>', '<?php echo e($data->tanggal_datang); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                                </svg>
                                                                Edit
                                                            </button>
                                                            <button onclick="deleteData('datang2024', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <!-- Enhanced No Data State -->
                            <div class="text-center py-16 relative">
                                <!-- Background decoration -->
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl opacity-50"></div>
                                
                                <!-- Content -->
                                <div class="relative">
                                    <div class="bg-gradient-to-br from-blue-100 to-purple-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    
                                    <h4 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                                        Data Tidak Ditemukan
                                    </h4>
                                    
                                    <?php if($search ?? false): ?>
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-blue-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk datang tahun 
                                                <span class="font-bold text-blue-600">2024</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-blue-100 to-purple-100 rounded-lg font-bold text-purple-700">
                                                    "<?php echo e($search); ?>"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk datang untuk tahun 
                                            <span class="font-bold text-blue-600">2024</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Datang 2025 -->
                    <div class="glass rounded-2xl p-6 shadow-xl border border-green-200/30">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-green-400 to-green-500 p-2 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900">Data Tahun 2025</h4>
                            </div>
                            <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm"><?php echo e(count($datang2025)); ?> records</span>
                        </div>
                        <?php if(count($datang2025) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-green-50 to-emerald-50 border-b-2 border-green-200">
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider rounded-tl-lg">Nama Lengkap</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Alamat Tujuan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Tanggal Datang</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-green-700 uppercase tracking-wider rounded-tr-lg w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-green-100">
                                        <?php $__currentLoopData = $datang2025; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900"><?php echo e($data->nama ?? '-'); ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat ?? '-', 35)); ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?php echo e($data->tanggal_datang ?? '-'); ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="relative inline-block text-left">
                                                    <button type="button" class="inline-flex items-center p-2 text-gray-400 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 rounded-full transition-colors" onclick="toggleDropdown('dropdown-datang2025-<?php echo e($data->id); ?>')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 6a2 2 0 110-4 2 2 0 010 4zM12 14a2 2 0 110-4 2 2 0 010 4zM12 22a2 2 0 110-4 2 2 0 010 4z"/>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdown-datang2025-<?php echo e($data->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                                        <div class="py-1">
                                                            <button onclick="editData('datang2025', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>', '<?php echo e($data->alamat); ?>', '<?php echo e($data->tanggal_datang); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                                </svg>
                                                                Edit
                                                            </button>
                                                            <button onclick="deleteData('datang2025', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <!-- Enhanced No Data State -->
                            <div class="text-center py-16 relative">
                                <!-- Background decoration -->
                                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl opacity-50"></div>
                                
                                <!-- Content -->
                                <div class="relative">
                                    <div class="bg-gradient-to-br from-green-100 to-emerald-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    
                                    <h4 class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3">
                                        Data Tidak Ditemukan
                                    </h4>
                                    
                                    <?php if($search ?? false): ?>
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-green-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk datang tahun 
                                                <span class="font-bold text-green-600">2025</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg font-bold text-green-700">
                                                    "<?php echo e($search); ?>"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk datang untuk tahun 
                                            <span class="font-bold text-green-600">2025</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Data Pindah Section -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Data Penduduk Pindah</h3>
                            <p class="text-sm text-gray-500">
                                <?php echo e(count($pindah2024) + count($pindah2025)); ?> total records
                                <?php if($search ?? false): ?>
                                    <span class="text-blue-600 font-medium">(hasil pencarian: "<?php echo e($search); ?>")</span>
                                <?php else: ?>
                                    (showing recent 100 per table)
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 bg-white/50 px-3 py-1 rounded-full">
                        Live Data
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Pindah 2024 -->
                    <div class="glass rounded-2xl p-6 shadow-xl border border-orange-200/30">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-orange-400 to-orange-500 p-2 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900">Data Tahun 2024</h4>
                            </div>
                            <span class="bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm"><?php echo e(count($pindah2024)); ?> records</span>
                        </div>
                        <?php if(count($pindah2024) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-orange-50 to-red-50 border-b-2 border-orange-200">
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider rounded-tl-lg">Nama</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider">Asal</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider">Tujuan</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-4 py-4 text-center text-xs font-bold text-orange-700 uppercase tracking-wider rounded-tr-lg w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-orange-100">
                                        <?php $__currentLoopData = $pindah2024; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 transition-all duration-200">
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900"><?php echo e($data->nama ?? '-'); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat_asal ?? '-', 20)); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat_tujuan ?? '-', 20)); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600 font-medium"><?php echo e($data->tanggal_pindah ?? '-'); ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="relative inline-block text-left">
                                                    <button type="button" class="inline-flex items-center p-2 text-gray-400 hover:text-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 rounded-full transition-colors" onclick="toggleDropdown('dropdown-pindah2024-<?php echo e($data->id); ?>')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 6a2 2 0 110-4 2 2 0 010 4zM12 14a2 2 0 110-4 2 2 0 010 4zM12 22a2 2 0 110-4 2 2 0 010 4z"/>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdown-pindah2024-<?php echo e($data->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                                        <div class="py-1">
                                                            <button onclick="editData('pindah2024', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>', '<?php echo e($data->alamat_asal); ?>', '<?php echo e($data->alamat_tujuan); ?>', '<?php echo e($data->tanggal_pindah); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                                </svg>
                                                                Edit
                                                            </button>
                                                            <button onclick="deleteData('pindah2024', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <!-- Enhanced No Data State -->
                            <div class="text-center py-16 relative">
                                <!-- Background decoration -->
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl opacity-50"></div>
                                
                                <!-- Content -->
                                <div class="relative">
                                    <div class="bg-gradient-to-br from-orange-100 to-red-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    
                                    <h4 class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-3">
                                        Data Tidak Ditemukan
                                    </h4>
                                    
                                    <?php if($search ?? false): ?>
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-orange-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk pindah tahun 
                                                <span class="font-bold text-orange-600">2024</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-orange-100 to-red-100 rounded-lg font-bold text-red-700">
                                                    "<?php echo e($search); ?>"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk pindah untuk tahun 
                                            <span class="font-bold text-orange-600">2024</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pindah 2025 -->
                    <div class="glass rounded-2xl p-6 shadow-xl border border-red-200/30">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-red-400 to-red-500 p-2 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900">Data Tahun 2025</h4>
                            </div>
                            <span class="bg-gradient-to-r from-red-100 to-red-200 text-red-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm"><?php echo e(count($pindah2025)); ?> records</span>
                        </div>
                        <?php if(count($pindah2025) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-red-50 to-pink-50 border-b-2 border-red-200">
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider rounded-tl-lg">Nama</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Asal</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Tujuan</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-4 py-4 text-center text-xs font-bold text-red-700 uppercase tracking-wider rounded-tr-lg w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-red-100">
                                        <?php $__currentLoopData = $pindah2025; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-200">
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900"><?php echo e($data->nama ?? '-'); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat_asal ?? '-', 20)); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600"><?php echo e(Str::limit($data->alamat_tujuan ?? '-', 20)); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-600 font-medium"><?php echo e($data->tanggal_pindah ?? '-'); ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="relative inline-block text-left">
                                                    <button type="button" class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full transition-colors" onclick="toggleDropdown('dropdown-pindah2025-<?php echo e($data->id); ?>')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 6a2 2 0 110-4 2 2 0 010 4zM12 14a2 2 0 110-4 2 2 0 010 4zM12 22a2 2 0 110-4 2 2 0 010 4z"/>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdown-pindah2025-<?php echo e($data->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                                        <div class="py-1">
                                                            <button onclick="editData('pindah2025', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>', '<?php echo e($data->alamat_asal); ?>', '<?php echo e($data->alamat_tujuan); ?>', '<?php echo e($data->tanggal_pindah); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                                </svg>
                                                                Edit
                                                            </button>
                                                            <button onclick="deleteData('pindah2025', <?php echo e($data->id); ?>, '<?php echo e($data->nama); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <!-- Enhanced No Data State -->
                            <div class="text-center py-16 relative">
                                <!-- Background decoration -->
                                <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl opacity-50"></div>
                                
                                <!-- Content -->
                                <div class="relative">
                                    <div class="bg-gradient-to-br from-red-100 to-pink-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    
                                    <h4 class="text-xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-3">
                                        Data Tidak Ditemukan
                                    </h4>
                                    
                                    <?php if($search ?? false): ?>
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-red-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk pindah tahun 
                                                <span class="font-bold text-red-600">2025</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-red-100 to-pink-100 rounded-lg font-bold text-pink-700">
                                                    "<?php echo e($search); ?>"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk pindah untuk tahun 
                                            <span class="font-bold text-red-600">2025</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-16">
            <div class="glass rounded-t-3xl p-8 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-gradient-to-r from-primary-500 to-indigo-600 p-3 rounded-xl shadow-lg mr-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Sistem Informasi Kependudukan</h3>
                        <p class="text-sm text-gray-600">Mengelola data pergerakan penduduk dengan efisien</p>
                    </div>
                </div>
                <div class="border-t border-white/20 pt-6 mt-6">
                    <p class="text-sm text-gray-500">
                        © 2025 Sistem Kependudukan
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Konfirmasi Hapus</h3>
                            <p class="text-red-100 text-sm">Tindakan ini tidak dapat dibatalkan</p>
                        </div>
                    </div>
                    <button onclick="closeDeleteModal()" class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Warning Icon -->
                <div class="flex justify-center mb-4">
                    <div class="bg-red-100 p-4 rounded-full">
                        <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <div class="text-center mb-6">
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Hapus Data Penduduk?</h4>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Nama:</span> 
                            <span id="deleteNama" class="text-gray-900"></span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold">Tabel:</span> 
                            <span id="deleteTable" class="text-gray-900 uppercase"></span>
                        </p>
                    </div>
                    <p class="text-gray-600">
                        Apakah Anda yakin ingin menghapus data ini? 
                        <span class="font-semibold text-red-600">Tindakan ini tidak dapat dibatalkan!</span>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="button" id="confirmDeleteButton"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:from-red-600 hover:to-red-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="editModalContent">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Edit Data</h3>
                            <p class="text-primary-100 text-sm" id="editTableInfo">Penduduk</p>
                        </div>
                    </div>
                    <button onclick="closeEditModal()" class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form -->
            <form id="editForm" class="p-6 space-y-5">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Nama Lengkap
                    </label>
                    <input type="text" id="editNama" name="nama" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white">
                </div>

                <!-- Fields untuk Datang -->
                <div id="datangFields" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            </svg>
                            Alamat
                        </label>
                        <textarea id="editAlamat" name="alamat" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                            </svg>
                            Tanggal Datang
                        </label>
                        <input type="date" id="editTanggalDatang" name="tanggal_datang"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <!-- Fields untuk Pindah -->
                <div id="pindahFields" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            </svg>
                            Alamat Asal
                        </label>
                        <textarea id="editAlamatAsal" name="alamat_asal" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            Alamat Tujuan
                        </label>
                        <textarea id="editAlamatTujuan" name="alamat_tujuan" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                            </svg>
                            Tanggal Pindah
                        </label>
                        <input type="date" id="editTanggalPindah" name="tanggal_pindah"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" 
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit" id="saveButton"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript untuk Dropdown dan Modal -->
    <script>
        // Toggle dropdown
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
            
            // Close all other dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick*="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(d => d.classList.add('hidden'));
            }
        });

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });

        // Edit Data Function
        function editData(table, id, nama, alamat1, alamat2OrTanggal, tanggal) {
            // Close dropdown
            const dropdown = document.querySelector(`#dropdown-${table}-${id}`);
            if (dropdown) dropdown.classList.add('hidden');
            
            // Show edit modal
            showEditModal(table, id, nama, alamat1, alamat2OrTanggal, tanggal);
        }

        // Show Edit Modal
        function showEditModal(table, id, nama, alamat1, alamat2OrTanggal, tanggal) {
            const modal = document.getElementById('editModal');
            const modalContent = document.getElementById('editModalContent');
            const tableInfo = document.getElementById('editTableInfo');
            const form = document.getElementById('editForm');
            
            // Set table info
            const tableNames = {
                'datang2024': 'Penduduk Datang 2024',
                'datang2025': 'Penduduk Datang 2025',
                'pindah2024': 'Penduduk Pindah 2024',
                'pindah2025': 'Penduduk Pindah 2025'
            };
            tableInfo.textContent = tableNames[table] || table;
            
            // Set form data
            form.dataset.table = table;
            form.dataset.id = id;
            
            // Fill form fields
            document.getElementById('editNama').value = nama || '';
            
            if (table.includes('datang')) {
                // Show datang fields, hide pindah fields
                document.getElementById('datangFields').classList.remove('hidden');
                document.getElementById('pindahFields').classList.add('hidden');
                
                document.getElementById('editAlamat').value = alamat1 || '';
                document.getElementById('editTanggalDatang').value = alamat2OrTanggal || '';
            } else {
                // Show pindah fields, hide datang fields
                document.getElementById('pindahFields').classList.remove('hidden');
                document.getElementById('datangFields').classList.add('hidden');
                
                document.getElementById('editAlamatAsal').value = alamat1 || '';
                document.getElementById('editAlamatTujuan').value = alamat2OrTanggal || '';
                document.getElementById('editTanggalPindah').value = tanggal || '';
            }
            
            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Close Edit Modal
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            const modalContent = document.getElementById('editModalContent');
            
            // Hide modal with animation
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Handle form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const table = this.dataset.table;
            const id = this.dataset.id;
            const saveButton = document.getElementById('saveButton');
            const originalButtonText = saveButton.innerHTML;
            
            // Show loading
            saveButton.disabled = true;
            saveButton.innerHTML = `
                <svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            
            // Prepare form data
            const formData = new FormData(this);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Send update request
            fetch(`/penduduk/update/${table}/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                saveButton.disabled = false;
                saveButton.innerHTML = originalButtonText;
                
                if (data.success) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMessage.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ${data.message}
                        </div>
                    `;
                    document.body.appendChild(successMessage);
                    
                    // Close modal and refresh
                    closeEditModal();
                    setTimeout(() => {
                        successMessage.remove();
                        location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    errorMessage.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                            ${data.message}
                        </div>
                    `;
                    document.body.appendChild(errorMessage);
                    
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                saveButton.disabled = false;
                saveButton.innerHTML = originalButtonText;
                
                console.error('Update error:', error);
                alert('Terjadi kesalahan saat mengupdate data');
            });
        });

        // Delete Data Function
        function deleteData(table, id, nama) {
            // Close dropdown
            const dropdown = document.querySelector(`#dropdown-${table}-${id}`);
            if (dropdown) dropdown.classList.add('hidden');
            
            // Show delete confirmation modal
            showDeleteModal(table, id, nama);
        }

        // Show Delete Modal
        function showDeleteModal(table, id, nama) {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            const deleteNamaEl = document.getElementById('deleteNama');
            const deleteTableEl = document.getElementById('deleteTable');
            const confirmButton = document.getElementById('confirmDeleteButton');
            
            // Set data
            deleteNamaEl.textContent = nama;
            deleteTableEl.textContent = table;
            
            // Store data for confirmation
            confirmButton.dataset.table = table;
            confirmButton.dataset.id = id;
            confirmButton.dataset.nama = nama;
            
            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Close Delete Modal
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            // Hide modal with animation
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Confirm Delete
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            const table = this.dataset.table;
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const originalButtonText = this.innerHTML;
            
            // Show loading state
            this.disabled = true;
            this.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menghapus...
            `;
            
            fetch(`/penduduk/delete/${table}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;
                this.innerHTML = originalButtonText;
                
                if (data.success) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMessage.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Data "${nama}" berhasil dihapus!
                        </div>
                    `;
                    document.body.appendChild(successMessage);
                    
                    // Close modal and refresh
                    closeDeleteModal();
                    setTimeout(() => {
                        successMessage.remove();
                        location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    errorMessage.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                            ${data.message}
                        </div>
                    `;
                    document.body.appendChild(errorMessage);
                    
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                this.disabled = false;
                this.innerHTML = originalButtonText;
                
                console.error('Delete error:', error);
                
                const errorMessage = document.createElement('div');
                errorMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                errorMessage.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        Terjadi kesalahan saat menghapus data
                    </div>
                `;
                document.body.appendChild(errorMessage);
                
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            });
        });
    </script>

</body>
</html><?php /**PATH C:\xampp\htdocs\disdukcapil\resources\views/penduduk.blade.php ENDPATH**/ ?>