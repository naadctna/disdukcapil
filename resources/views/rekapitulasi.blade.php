<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekapitulasi - Sistem Kependudukan</title>
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
                    <a href="{{ url('/penduduk') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        👥 Data Penduduk
                    </a>
                    <a href="{{ url('/rekapitulasi') }}" class="bg-blue-800 text-white px-3 py-2 rounded-md text-sm font-medium">
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
                    Rekapitulasi Penduduk
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Laporan lengkap data kependudukan per periode
                </p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card Datang 2024 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Datang 2024</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->datang2024 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Card Datang 2025 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Datang 2025</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->datang2025 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Card Pindah 2024 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-500 bg-opacity-75">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pindah 2024</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->pindah2024 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Card Pindah 2025 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pindah 2025</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $rekapitulasi->pindah2025 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekapitulasi Detail -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">📊 Rekapitulasi Lengkap</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Datang 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $rekapitulasi->datang2024 }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($rekapitulasi->total_datang > 0)
                                    {{ number_format(($rekapitulasi->datang2024 / $rekapitulasi->total_datang) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Datang 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $rekapitulasi->datang2025 }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($rekapitulasi->total_datang > 0)
                                    {{ number_format(($rekapitulasi->datang2025 / $rekapitulasi->total_datang) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Pindah 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                    {{ $rekapitulasi->pindah2024 }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($rekapitulasi->total_pindah > 0)
                                    {{ number_format(($rekapitulasi->pindah2024 / $rekapitulasi->total_pindah) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Pindah 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $rekapitulasi->pindah2025 }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($rekapitulasi->total_pindah > 0)
                                    {{ number_format(($rekapitulasi->pindah2025 / $rekapitulasi->total_pindah) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        <tr class="bg-blue-50 hover:bg-blue-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                📊 Total Datang
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-blue-200 text-blue-900">
                                    {{ $rekapitulasi->total_datang }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                100%
                            </td>
                        </tr>
                        <tr class="bg-red-50 hover:bg-red-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-900">
                                📊 Total Pindah
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-red-200 text-red-900">
                                    {{ $rekapitulasi->total_pindah }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-900">
                                100%
                            </td>
                        </tr>
                        <tr class="bg-green-50 hover:bg-green-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                🎯 Hasil Akhir (Datang - Pindah)
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-green-200 text-green-900">
                                    {{ $rekapitulasi->hasil_akhir }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                @if($rekapitulasi->total_datang > 0)
                                    {{ number_format(($rekapitulasi->hasil_akhir / $rekapitulasi->total_datang) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <a href="{{ url('/') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700">
                    🏠 Dashboard
                </a>
                <a href="{{ url('/penduduk') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700">
                    👥 Data Penduduk
                </a>
                <button onclick="window.print()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-r-md hover:bg-blue-700">
                    🖨️ Print Laporan
                </button>
            </div>
        </div>
    </div>
</body>
</html>