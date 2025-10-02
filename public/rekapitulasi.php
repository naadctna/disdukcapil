<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekapitulasi Penduduk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg mb-8 p-6">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-2">Rekapitulasi Penduduk</h1>
            <p class="text-gray-600 text-center">Sistem Informasi Kependudukan</p>
        </div>

        <?php
        // Koneksi ke database
        $host = "127.0.0.1";
        $user = "root";
        $pass = "";
        $db   = "disdukcapil";

        $conn = new mysqli($host, $user, $pass, $db);

        // Cek koneksi
        if ($conn->connect_error) {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">';
            echo "Koneksi gagal: " . $conn->connect_error;
            echo '<br><a href="setup_database.php" class="text-blue-600 underline">Klik di sini untuk setup database</a>';
            echo '</div>';
            exit;
        }

        // Query untuk rekapitulasi
        $sql = "
        SELECT 
            (SELECT COUNT(*) FROM datang2024) AS datang2024,
            (SELECT COUNT(*) FROM datang2025) AS datang2025,
            (SELECT COUNT(*) FROM pindah2024) AS pindah2024,
            (SELECT COUNT(*) FROM pindah2025) AS pindah2025,
            ((SELECT COUNT(*) FROM datang2024) + (SELECT COUNT(*) FROM datang2025)) AS total_datang,
            ((SELECT COUNT(*) FROM pindah2024) + (SELECT COUNT(*) FROM pindah2025)) AS total_pindah,
            (((SELECT COUNT(*) FROM datang2024) + (SELECT COUNT(*) FROM datang2025)) - 
             ((SELECT COUNT(*) FROM pindah2024) + (SELECT COUNT(*) FROM pindah2025))) AS hasil_akhir
        ";

        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        ?>

        <!-- Statistik Cards -->
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
                            <dd class="text-lg font-medium text-gray-900"><?= $data['datang2024'] ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= $data['datang2025'] ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= $data['pindah2024'] ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= $data['pindah2025'] ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekapitulasi Detail -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Rekapitulasi Lengkap</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Datang 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= $data['datang2024'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Datang 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <?= $data['datang2025'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Pindah 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                    <?= $data['pindah2024'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                📅 Jumlah Pindah 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <?= $data['pindah2025'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-blue-50 hover:bg-blue-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                📊 Total Datang
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-blue-200 text-blue-900">
                                    <?= $data['total_datang'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-red-50 hover:bg-red-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-900">
                                📊 Total Pindah
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-red-200 text-red-900">
                                    <?= $data['total_pindah'] ?> orang
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-green-50 hover:bg-green-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                🎯 Hasil Akhir (Datang - Pindah)
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                <span class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-green-200 text-green-900">
                                    <?= $data['hasil_akhir'] ?> orang
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <a href="index.php" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700">
                    🏠 Home
                </a>
                <a href="setup_database.php" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700">
                    ⚙️ Setup Database
                </a>
                <a href="rekapitulasi.php" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-r-md hover:bg-blue-700">
                    📊 Rekapitulasi
                </a>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>