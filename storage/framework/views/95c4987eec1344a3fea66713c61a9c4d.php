<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Test</title>
</head>
<body>
    <h1>Dashboard - Ultra Simple</h1>
    
    <p>Status: ✅ View berhasil dimuat</p>
    <p>Waktu: <?php echo e(date('Y-m-d H:i:s')); ?></p>
    
    <hr>
    
    <h2>Data Statistik</h2>
    <p>Total Datang: <?php echo e($rekapitulasi->total_datang ?? 'N/A'); ?></p>
    <p>Total Pindah: <?php echo e($rekapitulasi->total_pindah ?? 'N/A'); ?></p>
    <p>Selisih: <?php echo e($rekapitulasi->hasil_akhir ?? 'N/A'); ?></p>
    
    <div class="card">
        <h2>Menu</h2>
        <ul>
            <li><a href="/penduduk">Data Penduduk</a></li>
            <li><a href="/rekapitulasi">Rekapitulasi</a></li>
            <li><a href="/upload-excel">Upload Excel</a></li>
        </ul>
    </div>
    
    <div class="card">
        <h2>Debug Info</h2>
        <p>Server Time: <?php echo e(date('Y-m-d H:i:s')); ?></p>
        <p>Laravel Version: <?php echo e(app()->version()); ?></p>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\disdukcapil\resources\views/dashboard-simple.blade.php ENDPATH**/ ?>