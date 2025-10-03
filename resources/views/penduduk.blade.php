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

        .form-input {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .form-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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

        <!-- Section: Input Forms -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Input Data Penduduk</h2>
                    <p class="text-sm text-gray-600">Tambah data penduduk datang dan pindah</p>
                </div>
            </div>
        </div>

        <!-- Input Forms -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12">
            <!-- Form Penduduk Datang -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Pencatatan Penduduk Datang</h3>
                        <p class="text-sm text-gray-500">Input data penduduk yang baru datang</p>
                    </div>
                </div>

                <form action="{{ url('/tambah-datang') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" name="nama" required placeholder="Masukkan nama lengkap" 
                                class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                </svg>
                                Tanggal Datang
                            </label>
                            <input type="date" name="tanggal_datang" required 
                                class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            </svg>
                            Alamat
                        </label>
                        <input type="text" name="alamat" required placeholder="Alamat lengkap tujuan" 
                            class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                            </svg>
                            Tahun Pencatatan
                        </label>
                        <select name="tahun" required class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-shadow duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                        <span>Catat Data Penduduk Datang</span>
                    </button>
                </form>
            </div>

            <!-- Form Penduduk Pindah -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Pencatatan Penduduk Pindah</h3>
                        <p class="text-sm text-gray-500">Input data penduduk yang pindah</p>
                    </div>
                </div>

                <form action="{{ url('/tambah-pindah') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" name="nama" required placeholder="Masukkan nama lengkap" 
                                class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                </svg>
                                Tanggal Pindah
                            </label>
                            <input type="date" name="tanggal_pindah" required 
                                class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            </svg>
                            Alamat Asal
                        </label>
                        <input type="text" name="alamat_asal" required placeholder="Alamat asal sebelum pindah" 
                            class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            </svg>
                            Alamat Tujuan
                        </label>
                        <input type="text" name="alamat_tujuan" required placeholder="Alamat tujuan setelah pindah" 
                            class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                            </svg>
                            Tahun Pencatatan
                        </label>
                        <select name="tahun" required class="form-input w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500 transition-all duration-200">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-4 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-shadow duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                        <span>Catat Data Penduduk Pindah</span>
                    </button>
                </form>
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
                            <p class="text-sm text-gray-500">{{ count($datang2024) + count($datang2025) }} total records (showing recent 100 per table)</p>
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
                            <p class="text-sm text-gray-500">{{ count($pindah2024) + count($pindah2025) }} total records (showing recent 100 per table)</p>
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