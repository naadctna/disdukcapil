<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-white text-xl font-bold">📊 Sistem Kependudukan</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        🏠 Dashboard
                    </a>
                    <a href="{{ url('/penduduk') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        👥 Data Penduduk
                    </a>
                    <a href="{{ url('/rekapitulasi') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        📈 Rekapitulasi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Dashboard Kependudukan
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Overview dan statistik data kependudukan
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Datang -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">↗</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Datang</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->total_datang }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pindah -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">↙</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Pindah</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->total_pindah }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Akhir -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">=</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Hasil Akhir</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->hasil_akhir }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Growth Rate -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">%</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Growth Rate</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    @if($rekapitulasi->total_datang > 0)
                                        {{ number_format(($rekapitulasi->hasil_akhir / $rekapitulasi->total_datang) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Chart 1: Perbandingan Datang vs Pindah -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Perbandingan Datang vs Pindah</h3>
                <div class="h-64">
                    <canvas id="chartDatangPindah"></canvas>
                </div>
            </div>

            <!-- Chart 2: Trend per Tahun -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Data per Tahun</h3>
                <div class="h-64">
                    <canvas id="chartPerTahun"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Ringkasan Data
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold text-blue-600 mb-2">📅 Data Datang</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>2024:</span>
                                <span class="font-semibold">{{ $rekapitulasi->datang2024 }} orang</span>
                            </div>
                            <div class="flex justify-between">
                                <span>2025:</span>
                                <span class="font-semibold">{{ $rekapitulasi->datang2025 }} orang</span>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold text-red-600 mb-2">📤 Data Pindah</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>2024:</span>
                                <span class="font-semibold">{{ $rekapitulasi->pindah2024 }} orang</span>
                            </div>
                            <div class="flex justify-between">
                                <span>2025:</span>
                                <span class="font-semibold">{{ $rekapitulasi->pindah2025 }} orang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart 1: Datang vs Pindah
        const ctx1 = document.getElementById('chartDatangPindah').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Total Datang', 'Total Pindah'],
                datasets: [{
                    data: [{{ $rekapitulasi->total_datang }}, {{ $rekapitulasi->total_pindah }}],
                    backgroundColor: ['#10B981', '#EF4444'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Chart 2: Per Tahun
        const ctx2 = document.getElementById('chartPerTahun').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['2024', '2025'],
                datasets: [
                    {
                        label: 'Datang',
                        data: [{{ $rekapitulasi->datang2024 }}, {{ $rekapitulasi->datang2025 }}],
                        backgroundColor: '#10B981'
                    },
                    {
                        label: 'Pindah',
                        data: [{{ $rekapitulasi->pindah2024 }}, {{ $rekapitulasi->pindah2025 }}],
                        backgroundColor: '#EF4444'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>