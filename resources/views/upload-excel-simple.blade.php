<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
</body>
</html>