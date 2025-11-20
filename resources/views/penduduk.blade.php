<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <p class="text-xs text-primary-500 font-medium">Data Penduduk</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ url('/') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L12 2L3 7V9C3 10.1 3.9 11 5 11V17C5 18.1 5.9 19 7 19H9C10.1 19 11 18.1 11 17V15H13V17C13 18.1 13.9 19 15 19H17C18.1 19 19 18.1 19 17V11C20.1 11 21 10.1 21 9Z"/>
                        </svg>
                    </div>
                    <span class="text-emerald-600 text-sm font-semibold">+12%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Total Datang</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $rekapitulasi->total_datang ?? 0 }}</p>
                <div class="h-1 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full"></div>
            </div>

            <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-red-500 to-rose-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM17 20L19 18V10H18V7H17C17 5.9 16.1 5 15 5H9C7.9 5 7 5.9 7 7H6V10H5V18L7 20H17Z"/>
                        </svg>
                    </div>
                    <span class="text-red-600 text-sm font-semibold">-8%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Total Pindah</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $rekapitulasi->total_pindah ?? 0 }}</p>
                <div class="h-1 bg-gradient-to-r from-red-500 to-rose-600 rounded-full"></div>
            </div>

            <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-primary-600 text-sm font-semibold">+4%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Selisih</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ ($rekapitulasi->total_datang ?? 0) - ($rekapitulasi->total_pindah ?? 0) }}</p>
                <div class="h-1 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full"></div>
            </div>

            <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                    </div>
                    <span class="text-amber-600 text-sm font-semibold">Live</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Tahun Aktif</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ date('Y') }}</p>
                <div class="h-1 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="gradient-card rounded-2xl p-6 border border-white/20 shadow-xl mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Aksi Cepat</h3>
                    <p class="text-gray-600 text-sm">Kelola data penduduk dengan mudah</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        <span>Tambah Data</span>
                    </button>
                    <a href="/upload-excel" class="bg-gradient-to-r from-emerald-500 to-green-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        <span>Import Excel</span>
                    </a>
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
            <form method="GET" action="{{ route('penduduk') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pencarian</label>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIK..." class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Status</option>
                            <option value="datang" {{ ($status ?? '') === 'datang' ? 'selected' : '' }}>Datang</option>
                            <option value="pindah" {{ ($status ?? '') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <select name="tahun" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Tahun</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2020;
                                $endYear = $currentYear + 5;
                                $selectedTahun = $tahun ?? '';
                            @endphp
                            @for($year = $endYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <select name="bulan" class="w-full p-3 border border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="">Semua Bulan</option>
                            @php
                                $months = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                $selectedBulan = $bulan ?? '';
                            @endphp
                            @foreach($months as $value => $label)
                                <option value="{{ $value }}" {{ $selectedBulan == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                            </svg>
                            <span>Filter</span>
                        </button>
                        @if($search || $status || $tahun || ($bulan ?? ''))
                        <button type="button" onclick="clearFilters()" class="bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </button>
                        @endif
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
                    <div class="flex space-x-2">
                        <button class="bg-gradient-to-r from-emerald-500 to-green-600 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                            </svg>
                            <span>Export Excel</span>
                        </button>
                        <button class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                            </svg>
                            <span>Export PDF</span>
                        </button>
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
                        @forelse($penduduk ?? [] as $index => $p)
                        <tr class="hover:bg-primary-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $p->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">{{ $p->alamat ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $p->tanggal && $p->tanggal !== '-' ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ str_contains($p->jenis_data, 'Datang') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $p->jenis_data ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-1">
                                    <button onclick="viewDetail('{{ $p->table_source ?? (str_contains($p->jenis_data, 'Datang') ? (str_contains($p->jenis_data, '2024') ? 'datang2024' : 'datang2025') : (str_contains($p->jenis_data, '2024') ? 'pindah2024' : 'pindah2025')) }}', {{ $p->id }})" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editData('{{ $p->table_source ?? (str_contains($p->jenis_data, 'Datang') ? (str_contains($p->jenis_data, '2024') ? 'datang2024' : 'datang2025') : (str_contains($p->jenis_data, '2024') ? 'pindah2024' : 'pindah2025')) }}', {{ $p->id }})" class="text-primary-600 hover:text-primary-900 p-2 rounded-lg hover:bg-primary-50 transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ $p->table_source ?? (str_contains($p->jenis_data, 'Datang') ? (str_contains($p->jenis_data, '2024') ? 'datang2024' : 'datang2025') : (str_contains($p->jenis_data, '2024') ? 'pindah2024' : 'pindah2025')) }}', {{ $p->id }}, '{{ $p->nama }}')" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
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
                        @endforelse
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
        // Auto-submit form saat filter berubah
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.querySelector('select[name="status"]');
            const tahunSelect = document.querySelector('select[name="tahun"]');
            const searchInput = document.querySelector('input[name="search"]');
            const form = document.getElementById('filterForm');
            
            // Auto submit saat dropdown berubah
            statusSelect?.addEventListener('change', function() {
                form.submit();
            });
            
            tahunSelect?.addEventListener('change', function() {
                form.submit();
            });
            
            // Submit saat enter di search
            searchInput?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    form.submit();
                }
            });
            
            // Clear button functionality
            window.clearFilters = function() {
                window.location.href = '{{ route("penduduk") }}';
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

        // Edit Data Function
        function editData(table, id) {
            // Fetch data untuk edit
            fetch(`/penduduk/view/${table}/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateEditModal(data.data, table, id);
                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    alert('Gagal mengambil data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data.');
            });
        }

        // Populate Edit Modal
        function populateEditModal(data, table, id) {
            document.getElementById('editTable').value = table;
            document.getElementById('editId').value = id;
            document.getElementById('editNama').value = data.nama_lengkap || data.nama || '';
            document.getElementById('editAlamat').value = data.alamat || '';
            
            // Set tanggal berdasarkan jenis tabel
            if (table.includes('datang')) {
                document.getElementById('editTanggalLabel').textContent = 'Tanggal Datang';
                document.getElementById('editTanggal').value = data.tgl_datang || data.tanggal_datang || '';
            } else {
                document.getElementById('editTanggalLabel').textContent = 'Tanggal Pindah';
                document.getElementById('editTanggal').value = data.tanggal_pindah || '';
            }
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Save Edit Data
        function saveEditData() {
            const formData = new FormData();
            formData.append('nama', document.getElementById('editNama').value);
            formData.append('alamat', document.getElementById('editAlamat').value);
            formData.append('tanggal', document.getElementById('editTanggal').value);
            
            const table = document.getElementById('editTable').value;
            const id = document.getElementById('editId').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Show loading
            const saveBtn = document.getElementById('saveEditBtn');
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Menyimpan...';
            saveBtn.disabled = true;

            fetch(`/penduduk/update/${table}/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Data berhasil diupdate!');
                    closeEditModal();
                    window.location.reload();
                } else {
                    alert('Gagal update data: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data.');
            })
            .finally(() => {
                saveBtn.textContent = originalText;
                saveBtn.disabled = false;
            });
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
            const loadingHTML = '<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"><div class="bg-white p-6 rounded-lg"><i class="fas fa-spinner fa-spin text-2xl text-primary-500"></i><p class="mt-2">Menghapus data...</p></div></div>';
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
                document.querySelector('.fixed.inset-0.bg-black').remove();
                
                if (data.success) {
                    alert('Data berhasil dihapus!');
                    // Reload halaman untuk update data
                    window.location.reload();
                } else {
                    alert('Gagal menghapus data: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                // Remove loading
                const loadingEl = document.querySelector('.fixed.inset-0.bg-black');
                if (loadingEl) loadingEl.remove();
                
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
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

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all duration-300">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Edit Data</h3>
                            <p class="text-gray-600">Ubah informasi penduduk</p>
                        </div>
                    </div>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form onsubmit="event.preventDefault(); saveEditData();">
                    <input type="hidden" id="editTable">
                    <input type="hidden" id="editId">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="editNama" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea id="editAlamat" required rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                        
                        <div>
                            <label id="editTanggalLabel" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" id="editTanggal" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-3 mt-6">
                        <button type="button" onclick="closeEditModal()" 
                                class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-xl font-medium hover:bg-gray-300 transition-colors">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" id="saveEditBtn"
                                class="flex-1 px-4 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
