<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Kependudukan</title>
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
                        <p class="text-xs text-primary-500 font-medium">Dashboard Analytics</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ url('/') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
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
                    <a href="{{ url('/penduduk') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
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
                        Dashboard Kependudukan
                    </span>
                </h1>
                <p class="text-lg text-gray-600">Overview dan analisis data kependudukan real-time</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Total Datang Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Total Datang</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($rekapitulasi->total_datang) }}</p>
                        <p class="text-primary-500 text-sm mt-1">2024 - 2025</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Pindah Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Total Pindah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($rekapitulasi->total_pindah) }}</p>
                        <p class="text-primary-500 text-sm mt-1">2024 - 2025</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Selisih Card -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Selisih</p>
                        <p class="text-3xl font-bold {{ $rekapitulasi->hasil_akhir >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                            {{ $rekapitulasi->hasil_akhir >= 0 ? '+' : '' }}{{ number_format($rekapitulasi->hasil_akhir) }}
                        </p>
                        <p class="text-primary-500 text-sm mt-1">{{ $rekapitulasi->hasil_akhir >= 0 ? 'Surplus' : 'Defisit' }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-{{ $rekapitulasi->hasil_akhir >= 0 ? 'green' : 'red' }}-400 to-{{ $rekapitulasi->hasil_akhir >= 0 ? 'green' : 'red' }}-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            @if($rekapitulasi->hasil_akhir >= 0)
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
                        <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider">Growth Rate</p>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ $rekapitulasi->total_pindah > 0 ? number_format(($rekapitulasi->total_datang / $rekapitulasi->total_pindah) * 100, 1) : '0' }}%
                        </p>
                        <p class="text-primary-500 text-sm mt-1">Rasio Pertumbuhan</p>
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
                    <h3 class="text-xl font-bold text-gray-900">📊 Statistik Tahunan</h3>
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
                    <h3 class="text-xl font-bold text-gray-900">📊 Distribusi Data</h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"/>
                        </svg>
                        <span>Pie Chart</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass rounded-2xl p-8 shadow-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 text-primary-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 3l3.293 3.293-7 7 1.414 1.414 7-7L21 11V3z"/>
                    <path d="M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/>
                </svg>
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ url('/penduduk') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white p-4 rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">Kelola Data Penduduk</div>
                        <div class="text-sm opacity-90">Input & view data</div>
                    </div>
                </a>
                <a href="{{ url('/rekapitulasi') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white p-4 rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">Lihat Rekapitulasi</div>
                        <div class="text-sm opacity-90">Analisis mendalam</div>
                    </div>
                </a>
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">Status System</div>
                        <div class="text-sm opacity-90">Online & Ready</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Datang 2024', 'Datang 2025', 'Pindah 2024', 'Pindah 2025'],
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: [
                        {{ $rekapitulasi->datang2024 }},
                        {{ $rekapitulasi->datang2025 }},
                        {{ $rekapitulasi->pindah2024 }},
                        {{ $rekapitulasi->pindah2025 }}
                    ],
                    backgroundColor: [
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(147, 51, 234, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(220, 38, 38, 0.8)'
                    ],
                    borderColor: [
                        'rgb(168, 85, 247)',
                        'rgb(147, 51, 234)',
                        'rgb(239, 68, 68)',
                        'rgb(220, 38, 38)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Total Datang', 'Total Pindah'],
                datasets: [{
                    data: [{{ $rekapitulasi->total_datang }}, {{ $rekapitulasi->total_pindah }}],
                    backgroundColor: [
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(168, 85, 247)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>