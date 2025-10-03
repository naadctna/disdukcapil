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

        .stat-number {
            background: linear-gradient(45deg, #a855f7, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
                        <p class="text-xs text-primary-500 font-medium">Data Analytics</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ url('/') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Dashboard</span>
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-indigo-600/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-6 relative">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    Laporan Analitik
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Rekapitulasi Data Kependudukan
                    </span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Analisis mendalam pergerakan penduduk dengan visualisasi interaktif dan insights real-time
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <!-- Datang 2024 -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Datang 2024</p>
                        <p class="text-2xl font-bold stat-number">{{ number_format($rekapitulasi->datang2024) }}</p>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-blue-600 font-medium">Periode Tahun 2024</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Datang 2025 -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Datang 2025</p>
                        <p class="text-2xl font-bold stat-number">{{ number_format($rekapitulasi->datang2025) }}</p>
                    </div>
                </div>
                <div class="bg-green-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-green-600 font-medium">Periode Tahun 2025</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Pindah 2024 -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Pindah 2024</p>
                        <p class="text-2xl font-bold stat-number">{{ number_format($rekapitulasi->pindah2024) }}</p>
                    </div>
                </div>
                <div class="bg-orange-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-orange-600 font-medium">Periode Tahun 2024</span>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-semibold">Completed</span>
                    </div>
                </div>
            </div>

            <!-- Pindah 2025 -->
            <div class="gradient-card rounded-2xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Pindah 2025</p>
                        <p class="text-2xl font-bold stat-number">{{ number_format($rekapitulasi->pindah2025) }}</p>
                    </div>
                </div>
                <div class="bg-red-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-600 font-medium">Periode Tahun 2025</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Datang -->
            <div class="glass rounded-2xl p-8 shadow-xl text-center">
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($rekapitulasi->total_datang) }}</h3>
                <p class="text-primary-600 font-semibold mb-1">Total Penduduk Datang</p>
                <p class="text-sm text-gray-500">Periode 2024 - 2025</p>
            </div>

            <!-- Total Pindah -->
            <div class="glass rounded-2xl p-8 shadow-xl text-center">
                <div class="bg-gradient-to-br from-red-400 to-red-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4l-8 8 8 8-1.41 1.41L11.17 14H20v-2h-8.83l7.42-7.42z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($rekapitulasi->total_pindah) }}</h3>
                <p class="text-red-600 font-semibold mb-1">Total Penduduk Pindah</p>
                <p class="text-sm text-gray-500">Periode 2024 - 2025</p>
            </div>

            <!-- Net Migration -->
            <div class="glass rounded-2xl p-8 shadow-xl text-center">
                <div class="bg-gradient-to-br from-{{ $rekapitulasi->hasil_akhir >= 0 ? 'green' : 'red' }}-400 to-{{ $rekapitulasi->hasil_akhir >= 0 ? 'green' : 'red' }}-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        @if($rekapitulasi->hasil_akhir >= 0)
                        <path d="M7 14l5-5 5 5z"/>
                        @else
                        <path d="M7 10l5 5 5-5z"/>
                        @endif
                    </svg>
                </div>
                <h3 class="text-3xl font-bold {{ $rekapitulasi->hasil_akhir >= 0 ? 'text-green-600' : 'text-red-600' }} mb-2">
                    {{ $rekapitulasi->hasil_akhir >= 0 ? '+' : '' }}{{ number_format($rekapitulasi->hasil_akhir) }}
                </h3>
                <p class="{{ $rekapitulasi->hasil_akhir >= 0 ? 'text-green-600' : 'text-red-600' }} font-semibold mb-1">
                    Net Migration
                </p>
                <p class="text-sm text-gray-500">{{ $rekapitulasi->hasil_akhir >= 0 ? 'Population Growth' : 'Population Decline' }}</p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
            <!-- Comparison Chart -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Perbandingan Data</h3>
                        <p class="text-sm text-gray-500">Analisis pergerakan penduduk per tahun</p>
                    </div>
                    <div class="bg-primary-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 11H7v8h2v-8zm4-4h-2v12h2V7zm4-2h-2v14h2V5z"/>
                        </svg>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>

            <!-- Distribution Chart -->
            <div class="glass rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Distribusi Data</h3>
                        <p class="text-sm text-gray-500">Proporsi penduduk datang vs pindah</p>
                    </div>
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"/>
                        </svg>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trend Analysis -->
        <div class="glass rounded-2xl p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Analisis Tren</h3>
                    <p class="text-sm text-gray-500">Pergerakan data kependudukan dari waktu ke waktu</p>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <div class="bg-primary-100 text-primary-800 px-3 py-1 rounded-full font-medium">Real-time Data</div>
                </div>
            </div>
            <div class="h-96">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Comparison Bar Chart
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: ['2024', '2025'],
                datasets: [{
                    label: 'Datang',
                    data: [{{ $rekapitulasi->datang2024 }}, {{ $rekapitulasi->datang2025 }}],
                    backgroundColor: 'rgba(168, 85, 247, 0.8)',
                    borderColor: 'rgb(168, 85, 247)',
                    borderWidth: 2,
                    borderRadius: 8
                }, {
                    label: 'Pindah',
                    data: [{{ $rekapitulasi->pindah2024 }}, {{ $rekapitulasi->pindah2025 }}],
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
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

        // Distribution Pie Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(distributionCtx, {
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
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Trend Line Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['2024', '2025'],
                datasets: [{
                    label: 'Penduduk Datang',
                    data: [{{ $rekapitulasi->datang2024 }}, {{ $rekapitulasi->datang2025 }}],
                    borderColor: 'rgb(168, 85, 247)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Penduduk Pindah',
                    data: [{{ $rekapitulasi->pindah2024 }}, {{ $rekapitulasi->pindah2025 }}],
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Net Migration',
                    data: [
                        {{ $rekapitulasi->datang2024 - $rekapitulasi->pindah2024 }}, 
                        {{ $rekapitulasi->datang2025 - $rekapitulasi->pindah2025 }}
                    ],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
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
    </script>
</body>
</html>