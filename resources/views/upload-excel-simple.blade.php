<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
        }

        .toast-notification.hiding {
            animation: slideOutUp 0.5s ease-out;
        }

        @keyframes shrink {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Upload Data Excel</h1>
                </div>
                <nav class="flex space-x-4">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm">Beranda</a>
                    <a href="{{ url('/penduduk') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm">Data Penduduk</a>
                    <a href="{{ url('/rekapitulasi') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm">Rekapitulasi</a>
                    <a href="{{ url('/upload-excel') }}" class="bg-blue-600 text-white px-3 py-2 text-sm rounded">Upload Excel</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Upload File Excel</h2>
            <p class="text-gray-600">Upload file Excel (.xlsx, .xls) atau CSV untuk import data penduduk.</p>
        </div>

        <!-- Toast Notifications -->
        @if(session('success'))
        <div id="toast-success" class="toast-notification bg-white border-l-4 border-green-500 rounded-xl shadow-2xl overflow-hidden">
            <div class="p-4 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-gray-900">Berhasil!</p>
                    <p class="text-sm text-gray-600 mt-1">{!! str_replace(['<br>', '<br/>', '<br />'], ' ', session('success')) !!}</p>
                </div>
                <button onclick="closeToast('toast-success')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-green-500" style="animation: shrink 5s linear;"></div>
        </div>
        @endif

        @if(session('error'))
        <div id="toast-error" class="toast-notification bg-white border-l-4 border-red-500 rounded-xl shadow-2xl overflow-hidden">
            <div class="p-4 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-gray-900">Gagal!</p>
                    <p class="text-sm text-gray-600 mt-1">{!! str_replace(['<br>', '<br/>', '<br />'], ' ', session('error')) !!}</p>
                </div>
                <button onclick="closeToast('toast-error')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-red-500" style="animation: shrink 5s linear;"></div>
        </div>
        @endif

        @if($errors->any())
        <div id="toast-errors" class="toast-notification bg-white border-l-4 border-red-500 rounded-xl shadow-2xl overflow-hidden">
            <div class="p-4 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-gray-900">Terjadi Kesalahan!</p>
                    <ul class="text-sm text-gray-600 mt-1 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="closeToast('toast-errors')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-red-500" style="animation: shrink 5s linear;"></div>
        </div>
        @endif

        <!-- Upload Form -->
        <div class="bg-white rounded shadow p-6">
            <form action="{{ url('/upload-excel/process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- File Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih File Excel atau CSV
                    </label>
                    <input type="file" name="excel_file" accept=".csv,.xlsx,.xls" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Format yang didukung: .csv, .xlsx, .xls (Maksimal 10MB)</p>
                </div>

                <!-- Configuration -->
                <h3 class="text-lg font-medium mb-4">Konfigurasi Upload</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Data</label>
                        <select name="data_type" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih jenis data</option>
                            <option value="datang">Data Penduduk Datang</option>
                            <option value="pindah">Data Penduduk Pindah</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <select name="year" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih tahun</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bulan (Opsional)</label>
                        <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
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

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded font-medium">
                    Upload & Proses Data
                </button>
            </form>
        </div>

        <!-- Template Downloads -->
        <div class="mt-6 bg-white rounded shadow p-6">
            <h3 class="text-lg font-medium mb-4">Download Template</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium mb-2">Template Penduduk Datang</h4>
                    <a href="{{ url('/template_penduduk_datang.csv') }}" download 
                       class="inline-block bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
                        Download Template
                    </a>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Template Penduduk Pindah</h4>
                    <a href="{{ url('/template_penduduk_pindah.csv') }}" download 
                       class="inline-block bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                        Download Template
                    </a>
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
        });
    </script>
</body>
</html>