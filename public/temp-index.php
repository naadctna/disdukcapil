<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel + Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">
                🎉 Laravel Berhasil Diinstall!
            </h1>
            <p class="text-gray-600 text-center mb-6">
                Aplikasi Laravel fresh dengan Tailwind CSS sudah siap digunakan!
            </p>
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800">Framework</h3>
                    <p class="text-blue-600">Laravel 12.5.0</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-800">CSS Framework</h3>
                    <p class="text-green-600">Tailwind CSS (via CDN)</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="font-semibold text-purple-800">Status</h3>
                    <p class="text-purple-600">✅ Siap untuk development!</p>
                </div>
            </div>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Server: <?= $_SERVER['SERVER_NAME'] ?>:<?= $_SERVER['SERVER_PORT'] ?>
                </p>
                <p class="text-sm text-gray-500">
                    Time: <?= date('Y-m-d H:i:s') ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>