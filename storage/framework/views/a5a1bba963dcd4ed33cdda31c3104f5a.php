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
                        <p class="text-xs text-primary-500 font-medium">Pusat Informasi</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(url('/')); ?>" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="<?php echo e(url('/penduduk')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Data Penduduk</span>
                    </a>
                    
                    <a href="<?php echo e(url('/kecamatan')); ?>" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span>Wilayah</span>
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
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-indigo-600/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    <span class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">
                        Pusat Komando Digital
                    </span>
                </h1>
                <p class="text-lg text-gray-600">Monitoring dinamika perpindahan penduduk terkini</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-12">
        <!-- Stats Cards -->
        <div class="bg-white rounded-3xl p-8 shadow-lg mb-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Datang Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">TOTAL DATANG</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1"><?php echo e(number_format($rekapitulasi->total_datang)); ?></p>
                            <p class="text-purple-500 text-sm">2024 - 2025</p>
                        </div>
                        <div class="bg-green-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 7l1.41 1.41L5.83 11H16v2H5.83l2.58 2.59L7 17l-5-5z"/>
                                <path d="M20 5h-8V3h8c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2h-8v-2h8V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pindah Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">TOTAL PINDAH</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1"><?php echo e(number_format($rekapitulasi->total_pindah)); ?></p>
                            <p class="text-purple-500 text-sm">2024 - 2025</p>
                        </div>
                        <div class="bg-red-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5z"/>
                                <path d="M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Selisih Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">SELISIH</p>
                            <p class="text-4xl font-bold <?php echo e($rekapitulasi->hasil_akhir >= 0 ? 'text-green-600' : 'text-red-600'); ?> mb-1">
                                <?php echo e($rekapitulasi->hasil_akhir >= 0 ? '+' : ''); ?><?php echo e(number_format($rekapitulasi->hasil_akhir)); ?>

                            </p>
                            <p class="text-purple-500 text-sm"><?php echo e($rekapitulasi->hasil_akhir >= 0 ? 'Surplus' : 'Defisit'); ?></p>
                        </div>
                        <div class="bg-green-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 14l5-5 5 5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rasio Pertumbuhan Card -->
                <div class="bg-purple-50 rounded-2xl p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-3">RASIO PERTUMBUHAN</p>
                            <p class="text-4xl font-bold text-indigo-600 mb-1">
                                <?php echo e($rekapitulasi->total_pindah > 0 ? number_format(($rekapitulasi->total_datang / $rekapitulasi->total_pindah) * 100, 1) : '0'); ?>%
                            </p>
                            <p class="text-purple-500 text-sm">Perbandingan Datang dan Pindah</p>
                        </div>
                        <div class="bg-indigo-500 p-3 rounded-xl shadow-md flex-shrink-0 ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                            </svg>
                        </div>
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
                        <?php echo e($rekapitulasi->datang2024); ?>,
                        <?php echo e($rekapitulasi->datang2025); ?>,
                        <?php echo e($rekapitulasi->pindah2024); ?>,
                        <?php echo e($rekapitulasi->pindah2025); ?>

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
                    data: [<?php echo e($rekapitulasi->total_datang); ?>, <?php echo e($rekapitulasi->total_pindah); ?>],
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
</html><?php /**PATH D:\laragon\www\disdukcapil\resources\views/dashboard.blade.php ENDPATH**/ ?>