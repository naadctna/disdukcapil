<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Excel - Sistem Kependudukan</title>
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

        /* Toast Notification Styles */
        @keyframes slideInDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        @keyframes slideOutUp {
            from {
                transform: translate(-50%, 0);
                opacity: 1;
            }
            to {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
        }

        .toast-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            animation: slideInDown 0.5s ease-out;
            min-width: 320px;
            max-width: 500px;
            border-radius: 8px;
        }

        .toast-notification.hiding {
            animation: slideOutUp 0.5s ease-out;
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
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Upload Data Excel</h1>
                        <p class="text-xs text-gray-600">Sistem Informasi Kependudukan</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-1">
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
                    
                    <a href="{{ url('/kecamatan') }}" class="text-primary-700 hover:bg-primary-100/50 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span>Wilayah</span>
                    </a>
                    
                    <a href="{{ url('/upload-excel') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 15h2V9h3l-4-5-4 5h3z"/>
                            <path d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z"/>
                        </svg>
                        <span>Upload Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Upload File Excel</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Upload file Excel (.xlsx, .xls) atau CSV untuk import data penduduk ke dalam sistem.</p>
            </div>
        </div>

        <!-- Toast Notifications -->
        @if(session('success'))
        <div id="toast-success" class="toast-notification" style="background-color: #10b981;">
            <div class="p-4 flex items-center space-x-3 text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium">Berhasil!</p>
                    <p class="text-sm opacity-90">{!! str_replace(['<br>', '<br/>', '<br />'], ' ', session('success')) !!}</p>
                </div>
                <button onclick="closeToast('toast-success')" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="toast-error" class="toast-notification" style="background-color: #ef4444;">
            <div class="p-4 flex items-center space-x-3 text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium">Gagal!</p>
                    <p class="text-sm opacity-90">{!! str_replace(['<br>', '<br/>', '<br />'], ' ', session('error')) !!}</p>
                </div>
                <button onclick="closeToast('toast-error')" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div id="toast-errors" class="toast-notification" style="background-color: #ef4444;">
            <div class="p-4 flex items-center space-x-3 text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium">Terjadi Kesalahan!</p>
                    <ul class="text-sm opacity-90 mt-1 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="closeToast('toast-errors')" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Upload Form -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-8">
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Upload File</h3>
                    <p class="text-gray-600">Pilih file dan atur konfigurasi upload</p>
                </div>
            </div>

            <form action="{{ url('/upload-excel/process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- File Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Pilih File Excel atau CSV
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary-400 transition-colors bg-gray-50">
                        <div class="w-12 h-12 mx-auto mb-4 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex justify-center">
                            <input type="file" name="excel_file" accept=".csv,.xlsx,.xls,.txt" required 
                                   class="text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600 file:cursor-pointer cursor-pointer file:shadow-lg hover:file:shadow-xl file:transition-all file:duration-200">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Drag and drop file di sini atau klik untuk memilih</p>
                    </div>
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-blue-800">Format yang didukung:</p>
                                <p class="text-blue-700">• Ekstensi: .csv, .xlsx, .xls, .txt</p>
                                <p class="text-blue-700">• Ukuran maksimal: 40MB</p>
                                <p class="text-blue-600 text-xs mt-1">Sistem akan otomatis mendeteksi format dan struktur data Anda</p>
                                <p class="text-red-600 text-xs mt-1"><strong>⚠️ Penting:</strong> Jangan refresh halaman saat upload sedang berjalan!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Konfigurasi Upload
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Jenis Data</label>
                            <select name="data_type" required class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                <option value="">Pilih jenis data</option>
                                <option value="datang">Data Penduduk Datang</option>
                                <option value="pindah">Data Penduduk Pindah</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <select name="year" required class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                <option value="">Pilih tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2020;
                                    $endYear = $currentYear + 5; // 5 tahun ke depan
                                @endphp
                                @for($year = $endYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Bulan (Opsional)</label>
                            <select name="month" class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                <option value="">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3.5 px-6 rounded-md font-medium transition-all duration-200 flex items-center justify-center space-x-2 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span>Upload & Proses Data</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Template Downloads -->
        <div class="glass rounded-2xl shadow-2xl p-8 mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Download Template Excel</h3>
                    <p class="text-gray-600">Download template sesuai format standar yang berlaku</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Template Datang -->
                <div class="gradient-card rounded-xl p-6 border border-purple-200">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 mb-2">Template DATANG</h4>
                            <p class="text-sm text-gray-600 mb-3">Format standar 29 kolom untuk data penduduk datang (berlaku untuk semua tahun)</p>
                            <div class="flex flex-col space-y-2">
                                <a href="{{ asset('template_datang_standard.csv') }}" download class="inline-flex items-center justify-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Template CSV
                                </a>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 space-y-1">
                                <p>✓ NIK, NO_KK, NAMA_LENGKAP</p>
                                <p>✓ Data Asal & Tujuan Lengkap</p>
                                <p>✓ 29 kolom standar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Pindah -->
                <div class="gradient-card rounded-xl p-6 border border-indigo-200">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 mb-2">Template PINDAH</h4>
                            <p class="text-sm text-gray-600 mb-3">Format standar 32 kolom untuk data penduduk pindah (berlaku untuk semua tahun)</p>
                            <div class="flex flex-col space-y-2">
                                <a href="{{ asset('template_pindah_standard.csv') }}" download class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Template CSV
                                </a>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 space-y-1">
                                <p>✓ NIK, NO_KK, NAMA_LENGKAP</p>
                                <p>✓ Jenis & Alasan Pindah</p>
                                <p>✓ 32 kolom standar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Format Guide -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm">
                        <p class="font-semibold text-blue-800 mb-2">Panduan Upload:</p>
                        <ul class="space-y-1 text-blue-700">
                            <li>• Format yang sama untuk semua tahun (2024, 2025, dst)</li>
                            <li>• Urutan kolom harus sesuai template</li>
                            <li>• Format tanggal: YYYY-MM-DD atau DD/MM/YYYY</li>
                            <li>• File bisa dalam format .CSV, .XLSX, atau .XLS</li>
                            <li>• Lihat <a href="{{ asset('FORMAT_EXCEL_GUIDE.md') }}" class="underline font-medium" target="_blank">FORMAT_EXCEL_GUIDE.md</a> untuk detail lengkap</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script>
        // Toast notification functions
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }

        // Auto-dismiss toast after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-notification');
            toasts.forEach(toast => {
                setTimeout(() => {
                    closeToast(toast.id);
                }, 5000);
            });

            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');
            const fileInput = document.querySelector('input[type="file"]');
            
            // Handle form submission
            form.addEventListener('submit', function(e) {
                // Check if file is selected
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Silakan pilih file terlebih dahulu!');
                    return false;
                }
                
                // Check file size (40MB = 40 * 1024 * 1024 bytes)
                if (fileInput.files[0].size > 40 * 1024 * 1024) {
                    e.preventDefault();
                    alert('File terlalu besar! Maksimal 40MB.');
                    return false;
                }
                
                // Show loading state
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupload... Mohon tunggu';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
                
                // Prevent double submit
                setTimeout(() => {
                    form.style.pointerEvents = 'none';
                }, 100);
            });
            
            // Show file info when selected
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2);
                    console.log(`File selected: ${file.name} (${fileSize}MB)`);
                }
            });
        });
    </script>
</body>
</html>