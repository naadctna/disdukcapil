<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk - Sistem Kep                    <div class="bg-gradient-to-br from-primary-400 to-primary-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>ukan</title>
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
                    <a href="{{ url('/') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ url('/rekapitulasi') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        <span>Rekapitulasi</span>
                    </a>
                    <a href="{{ url('/penduduk') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    <a href="{{ url('/upload-excel') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
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
                        @if($search ?? false)
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 px-4 py-2 rounded-full border border-green-200">
                            <span class="text-sm font-semibold text-green-700 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mode Pencarian Aktif
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ url('/penduduk') }}" class="space-y-4">
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
                                           value="{{ $search ?? '' }}"
                                           placeholder="Ketik nama penduduk yang ingin dicari..." 
                                           class="search-input relative w-full pl-12 pr-4 py-4 bg-white/90 backdrop-blur-sm rounded-2xl border border-white/30 focus:border-purple-300 focus:ring-2 focus:ring-purple-200 transition-all duration-300 text-gray-800 placeholder-gray-400 shadow-lg hover:shadow-xl font-medium"
                                           autocomplete="off"
                                           spellcheck="false">
                                    
                                    <!-- Clear button for input -->
                                    @if($search ?? false)
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="document.querySelector('input[name=search]').value=''" 
                                                class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
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
                                @if($search ?? false)
                                    <a href="{{ url('/penduduk') }}" 
                                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center space-x-2 transform hover:scale-105 active:scale-95 group">
                                        <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <span>Reset</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Quick Search Suggestions -->
                        @if(!($search ?? false))
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
                        @endif
                    </form>
                
                @if($search ?? false)
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
                                                "{{ $search }}"
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Quick Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ url('/penduduk') }}" 
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
                @endif
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-8 glass rounded-2xl p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-green-800 font-medium">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16 mt-12">
            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Total Datang 2024</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($datang2024) }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ count($datang2025) }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ count($pindah2024) }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ count($pindah2025) }}</p>
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
                                {{ count($datang2024) + count($datang2025) }} total records
                                @if($search ?? false)
                                    <span class="text-blue-600 font-medium">(hasil pencarian: "{{ $search }}")</span>
                                @else
                                    (showing recent 100 per table)
                                @endif
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
                            <span class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm">{{ count($datang2024) }} records</span>
                        </div>
                        @if(count($datang2024) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b-2 border-blue-200">
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider rounded-tl-lg">Nama Lengkap</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Alamat Tujuan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider rounded-tr-lg">Tanggal Datang</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100">
                                        @foreach($datang2024 as $data)
                                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $data->NAMA_LENGKAP ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_TUJUAN ?? $data->ALAMAT_ASAL ?? '-', 35) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $data->TGL_DATANG ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
                                    
                                    @if($search ?? false)
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-blue-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk datang tahun 
                                                <span class="font-bold text-blue-600">2024</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-blue-100 to-purple-100 rounded-lg font-bold text-purple-700">
                                                    "{{ $search }}"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk datang untuk tahun 
                                            <span class="font-bold text-blue-600">2024</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
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
                            <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm">{{ count($datang2025) }} records</span>
                        </div>
                        @if(count($datang2025) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-green-50 to-emerald-50 border-b-2 border-green-200">
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider rounded-tl-lg">Nama Lengkap</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Alamat Tujuan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider rounded-tr-lg">Tanggal Datang</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-green-100">
                                        @foreach($datang2025 as $data)
                                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $data->NAMA_LENGKAP ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_TUJUAN ?? $data->ALAMAT_ASAL ?? '-', 35) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $data->TGL_DATANG ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
                                    
                                    @if($search ?? false)
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-green-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk datang tahun 
                                                <span class="font-bold text-green-600">2025</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg font-bold text-green-700">
                                                    "{{ $search }}"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk datang untuk tahun 
                                            <span class="font-bold text-green-600">2025</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
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
                                {{ count($pindah2024) + count($pindah2025) }} total records
                                @if($search ?? false)
                                    <span class="text-blue-600 font-medium">(hasil pencarian: "{{ $search }}")</span>
                                @else
                                    (showing recent 100 per table)
                                @endif
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
                            <span class="bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm">{{ count($pindah2024) }} records</span>
                        </div>
                        @if(count($pindah2024) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-orange-50 to-red-50 border-b-2 border-orange-200">
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider rounded-tl-lg">Nama</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider">Asal</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider">Tujuan</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-orange-700 uppercase tracking-wider rounded-tr-lg">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-orange-100">
                                        @foreach($pindah2024 as $data)
                                        <tr class="hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 transition-all duration-200">
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $data->NAMA_LENGKAP ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_ASAL ?? '-', 20) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_TUJUAN ?? '-', 20) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 font-medium">{{ $data->TGL_PINDAH ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
                                    
                                    @if($search ?? false)
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-orange-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk pindah tahun 
                                                <span class="font-bold text-orange-600">2024</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-orange-100 to-red-100 rounded-lg font-bold text-red-700">
                                                    "{{ $search }}"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk pindah untuk tahun 
                                            <span class="font-bold text-orange-600">2024</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
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
                            <span class="bg-gradient-to-r from-red-100 to-red-200 text-red-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm">{{ count($pindah2025) }} records</span>
                        </div>
                        @if(count($pindah2025) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-red-50 to-pink-50 border-b-2 border-red-200">
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider rounded-tl-lg">Nama</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Asal</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Tujuan</th>
                                            <th class="px-4 py-4 text-left text-xs font-bold text-red-700 uppercase tracking-wider rounded-tr-lg">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-red-100">
                                        @foreach($pindah2025 as $data)
                                        <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-200">
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $data->NAMA_LENGKAP ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_ASAL ?? '-', 20) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($data->ALAMAT_TUJUAN ?? '-', 20) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 font-medium">{{ $data->TGL_PINDAH ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
                                    
                                    @if($search ?? false)
                                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 mx-auto max-w-md border border-red-200/50">
                                            <p class="text-gray-700 font-medium">
                                                Tidak ada data penduduk pindah tahun 
                                                <span class="font-bold text-red-600">2025</span> 
                                                dengan nama 
                                                <span class="px-2 py-1 bg-gradient-to-r from-red-100 to-pink-100 rounded-lg font-bold text-pink-700">
                                                    "{{ $search }}"
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Coba gunakan kata kunci yang berbeda
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-600 font-medium">
                                            Belum ada data penduduk pindah untuk tahun 
                                            <span class="font-bold text-red-600">2025</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Data akan muncul setelah ada input pertama
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
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


</body>
</html>