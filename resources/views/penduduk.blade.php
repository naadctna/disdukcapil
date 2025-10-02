<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Penduduk - Sistem Kependudukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{ url('/penduduk') }}" class="bg-blue-800 text-white px-3 py-2 rounded-md text-sm font-medium">
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
                    📝 Pencatatan Keluar Masuk Penduduk
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Sistem pencatatan sederhana untuk rekapitulasi penduduk datang dan pindah
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Form Tambah Datang -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">➕ Pencatatan Penduduk Datang</h3>
                <form action="{{ url('/tambah-datang') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="nama" required placeholder="Nama penduduk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Datang</label>
                                <input type="date" name="tanggal_datang" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input type="text" name="alamat" required placeholder="Alamat penduduk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Pencatatan</label>
                            <select name="tahun" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border">
                                <option value="2024">2024</option>
                                <option value="2025" selected>2025</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:ring-2 focus:ring-green-500">
                            📝 Catat Penduduk Datang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Tambah Pindah -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">➖ Pencatatan Penduduk Pindah</h3>
                <form action="{{ url('/tambah-pindah') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="nama" required placeholder="Nama penduduk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pindah</label>
                                <input type="date" name="tanggal_pindah" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2 border">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Asal</label>
                                <input type="text" name="alamat_asal" required placeholder="Alamat asal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Tujuan</label>
                                <input type="text" name="alamat_tujuan" required placeholder="Alamat tujuan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2 border">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Pencatatan</label>
                            <select name="tahun" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2 border">
                                <option value="2024">2024</option>
                                <option value="2025" selected>2025</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500">
                            📝 Catat Penduduk Pindah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Data Datang 2024 -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-blue-900 mb-4">📊 Data Datang 2024 ({{ count($datang2024) }} orang)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-blue-700 uppercase">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-blue-700 uppercase">Alamat</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-blue-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($datang2024 as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm text-gray-900">{{ $data->nama }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat, 30) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ $data->tanggal_datang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Datang 2025 -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-green-900 mb-4">📊 Data Datang 2025 ({{ count($datang2025) }} orang)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-green-700 uppercase">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-green-700 uppercase">Alamat</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-green-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($datang2025 as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm text-gray-900">{{ $data->nama }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat, 30) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ $data->tanggal_datang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Pindah 2024 -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-orange-900 mb-4">📊 Data Pindah 2024 ({{ count($pindah2024) }} orang)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-orange-700 uppercase">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-orange-700 uppercase">Asal</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-orange-700 uppercase">Tujuan</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-orange-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pindah2024 as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm text-gray-900">{{ $data->nama }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat_asal, 20) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat_tujuan, 20) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ $data->tanggal_pindah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Pindah 2025 -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-red-900 mb-4">📊 Data Pindah 2025 ({{ count($pindah2025) }} orang)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-red-700 uppercase">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-red-700 uppercase">Asal</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-red-700 uppercase">Tujuan</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-red-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pindah2025 as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm text-gray-900">{{ $data->nama }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat_asal, 20) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ Str::limit($data->alamat_tujuan, 20) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-500">{{ $data->tanggal_pindah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>