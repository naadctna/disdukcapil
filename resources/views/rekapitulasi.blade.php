<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <p class="text-xs text-primary-500 font-medium">Rekapitulasi Data</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ url('/') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ url('/rekapitulasi') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        <span>Rekapitulasi</span>
                    </a>
                    <a href="{{ url('/penduduk') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    
                    <a href="{{ url('/kecamatan') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
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

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-indigo-600/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Rekapitulasi Data Penduduk
                    </span>
                </h1>
                <p class="text-lg text-gray-600">Laporan dan statistik komprehensif data perpindahan penduduk</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">

        <!-- Filter Section -->
        <div class="glass rounded-2xl p-8 shadow-xl mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">🔍 Filter Data</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/>
                    </svg>
                    <span>Pencarian Lanjutan</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-primary-600 mb-2 uppercase tracking-wide">Tahun</label>
                    <select class="w-full p-3 bg-white/50 backdrop-filter backdrop-blur border border-primary-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-600 mb-2 uppercase tracking-wide">Bulan</label>
                    <select class="w-full p-3 bg-white/50 backdrop-filter backdrop-blur border border-primary-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        <span>Filter Data</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Total Datang Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Total Datang</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($rekapitulasi->total_datang ?? 0) }}</p>
                        <p class="text-primary-500 text-sm mt-1">2024 - 2025</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 7l1.41 1.41L5.83 11H16v2H5.83l2.58 2.59L7 17l-5-5z"/>
                            <path d="M20 5h-8V3h8c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2h-8v-2h8V5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Pindah Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Total Pindah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($rekapitulasi->total_pindah ?? 0) }}</p>
                        <p class="text-primary-500 text-sm mt-1">2024 - 2025</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5z"/>
                            <path d="M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Selisih Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Selisih</p>
                        <p class="text-3xl font-bold {{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                            {{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? '+' : '' }}{{ number_format($rekapitulasi->hasil_akhir ?? 0) }}
                        </p>
                        <p class="text-primary-500 text-sm mt-1">{{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? 'Surplus' : 'Defisit' }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-{{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? 'green' : 'red' }}-400 to-{{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? 'green' : 'red' }}-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            @if(($rekapitulasi->hasil_akhir ?? 0) >= 0)
                            <path d="M7 14l5-5 5 5z"/>
                            @else
                            <path d="M7 10l5 5 5-5z"/>
                            @endif
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Growth Rate Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Rasio Pertumbuhan</p>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ ($rekapitulasi->total_pindah ?? 0) > 0 ? number_format((($rekapitulasi->total_datang ?? 0) / ($rekapitulasi->total_pindah ?? 0)) * 100, 1) : '0' }}%
                        </p>
                        <p class="text-primary-500 text-sm mt-1">Perbandingan Datang dan Pindah</p>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
            <!-- Bar Chart -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">📊 Statistik Bulanan</h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 11H7v8h2v-8zm4-4h-2v12h2V7zm4-2h-2v14h2V5z"/>
                        </svg>
                        <span>Bar Chart</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">🎯 Distribusi Data</h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>Pie Chart</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="glass rounded-2xl p-8 shadow-xl">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
                <h3 class="text-xl font-bold text-gray-900">📋 Detail Rekapitulasi</h3>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <button class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                        <span>Export Excel</span>
                    </button>
                    <button class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                        <span>Export PDF</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-primary-500/10 to-primary-600/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary-700 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary-700 uppercase tracking-wider">Penduduk Datang</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary-700 uppercase tracking-wider">Penduduk Pindah</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary-700 uppercase tracking-wider">Selisih</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary-700 uppercase tracking-wider">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 backdrop-filter backdrop-blur divide-y divide-primary-100">
                        <tr class="hover:bg-primary-50/50 transition-all duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Oktober 2025</td>
                            <td class="px-6 py-4 text-sm font-bold text-green-600">{{ number_format($rekapitulasi->total_datang ?? 0) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-red-600">{{ number_format($rekapitulasi->total_pindah ?? 0) }}</td>
                            <td class="px-6 py-4 text-sm font-bold {{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ ($rekapitulasi->hasil_akhir ?? 0) >= 0 ? '+' : '' }}{{ number_format($rekapitulasi->hasil_akhir ?? 0) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-indigo-600">
                                {{ ($rekapitulasi->total_pindah ?? 0) > 0 ? number_format((($rekapitulasi->total_datang ?? 0) / ($rekapitulasi->total_pindah ?? 0)) * 100, 1) : '0' }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penduduk Datang',
                    data: [12, 19, 3, 5, 2, 3, 8, 12, 15, {{ $rekapitulasi->total_datang ?? 0 }}, 0, 0],
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                }, {
                    label: 'Penduduk Pindah',
                    data: [8, 11, 7, 2, 4, 1, 5, 8, 10, {{ $rekapitulasi->total_pindah ?? 0 }}, 0, 0],
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Penduduk Datang', 'Penduduk Pindah'],
                datasets: [{
                    data: [{{ $rekapitulasi->total_datang ?? 0 }}, {{ $rekapitulasi->total_pindah ?? 0 }}],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
