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
                    <a href="{{ url('/') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ url('/penduduk') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    
                    <a href="{{ url('/kecamatan') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span>Wilayah</span>
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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <!-- Header with back button if filtered by kecamatan -->
        <div class="mb-8">
            @if(request('kecamatan'))
            <a href="{{ url('/kelurahan') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-4 font-semibold">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
                Kembali ke Semua Kelurahan
            </a>
            @endif
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                    Data Kelurahan
                    @if(request('kecamatan'))
                    <span class="text-2xl">- {{ request('kecamatan') }}</span>
                    @endif
                </span>
            </h2>
            <p class="text-gray-600">Daftar kelurahan berdasarkan data perpindahan penduduk</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Kelurahan -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Total Kelurahan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($kelurahan->count()) }}</p>
                        @if(request('kecamatan'))
                        <p class="text-xs text-gray-500 mt-1">di {{ request('kecamatan') }}</p>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Datang -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-semibold uppercase tracking-wider">Total Datang</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($kelurahan->sum('datang')) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Pindah -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-semibold uppercase tracking-wider">Total Pindah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($kelurahan->sum('pindah')) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 12h-2v3h-3v2h5v-5zM7 9h3V7H5v5h2V9zm14-6H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar & Filter -->
        <div class="mb-6">
            <form method="GET" action="{{ url('/kelurahan') }}" class="flex gap-3 flex-wrap">
                @if(request('kecamatan'))
                <input type="hidden" name="kecamatan" value="{{ request('kecamatan') }}">
                @endif
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}" 
                           placeholder="🔍 Cari kelurahan atau kecamatan..." 
                           class="w-full px-4 py-3 rounded-xl border border-primary-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200">
                </div>
                <select name="jenis" class="px-4 py-3 rounded-xl border border-primary-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 bg-white font-semibold">
                    <option value="">📊 Semua Data</option>
                    <option value="datang" {{ ($jenis ?? '') === 'datang' ? 'selected' : '' }}>📥 Datang</option>
                    <option value="pindah" {{ ($jenis ?? '') === 'pindah' ? 'selected' : '' }}>📤 Pindah</option>
                </select>
                <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <span>Cari</span>
                </button>
                @if($search || $jenis)
                <a href="{{ url('/kelurahan' . (request('kecamatan') ? '?kecamatan=' . urlencode(request('kecamatan')) : '')) }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                    <span>Reset</span>
                </a>
                @endif
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
                        @forelse($kelurahan as $index => $item)
                        <tr class="hover:bg-primary-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                                    </svg>
                                    <span>{{ $item['kelurahan'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                                        <circle cx="12" cy="9" r="2.5"/>
                                    </svg>
                                    <span>{{ $item['kecamatan'] ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7 10l5 5 5-5z"/>
                                    </svg>
                                    {{ number_format($item['datang'] ?? 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7 14l5-5 5 5z"/>
                                    </svg>
                                    {{ number_format($item['pindah'] ?? 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center font-bold text-gray-900">{{ number_format($item['jumlah']) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"/>
                                </svg>
                                <p class="text-lg font-semibold">Tidak ada data kelurahan</p>
                                <p class="text-sm">Silakan upload data terlebih dahulu</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary with Analytics -->
        @if($kelurahan->count() > 0)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kelurahan Terbanyak Datang -->
            <div class="gradient-card rounded-xl p-6 shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-green-600 font-semibold uppercase tracking-wider mb-2">📥 Terbanyak Datang</p>
                        <p class="text-lg font-bold text-gray-900">{{ $kelurahan->sortByDesc('datang')->first()['kelurahan'] }}</p>
                        <p class="text-xs text-gray-500">{{ $kelurahan->sortByDesc('datang')->first()['kecamatan'] ?? '-' }}</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($kelurahan->sortByDesc('datang')->first()['datang']) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kelurahan Terbanyak Pindah -->
            <div class="gradient-card rounded-xl p-6 shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-red-600 font-semibold uppercase tracking-wider mb-2">📤 Terbanyak Pindah</p>
                        <p class="text-lg font-bold text-gray-900">{{ $kelurahan->sortByDesc('pindah')->first()['kelurahan'] }}</p>
                        <p class="text-xs text-gray-500">{{ $kelurahan->sortByDesc('pindah')->first()['kecamatan'] ?? '-' }}</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($kelurahan->sortByDesc('pindah')->first()['pindah']) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 12h-2v3h-3v2h5v-5zM7 9h3V7H5v5h2V9zm14-6H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Selisih Total -->
            @php
                $totalDatang = $kelurahan->sum('datang');
                $totalPindah = $kelurahan->sum('pindah');
                $selisih = $totalDatang - $totalPindah;
            @endphp
            <div class="gradient-card rounded-xl p-6 shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-primary-600 font-semibold uppercase tracking-wider mb-2">⚖️ Selisih Bersih</p>
                        <p class="text-lg font-bold text-gray-900">Datang - Pindah</p>
                        <p class="text-2xl font-bold {{ $selisih >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $selisih >= 0 ? 'Surplus' : 'Defisit' }} populasi
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-{{ $selisih >= 0 ? 'green' : 'red' }}-400 to-{{ $selisih >= 0 ? 'green' : 'red' }}-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                            @if($selisih >= 0)
                            <path d="M7 14l5-5 5 5z"/>
                            @else
                            <path d="M7 10l5 5 5-5z"/>
                            @endif
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
