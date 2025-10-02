<?php
// Koneksi ke database
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "disdukcapil";

$conn = new mysqli($host, $user, $pass);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS disdukcapil";
if ($conn->query($sql) === TRUE) {
    echo "Database disdukcapil berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

// Pilih database
$conn->select_db($db);

// Buat tabel datang2024
$sql = "CREATE TABLE IF NOT EXISTS datang2024 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    alamat TEXT,
    tanggal_datang DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabel datang2024 berhasil dibuat.<br>";
}

// Buat tabel datang2025  
$sql = "CREATE TABLE IF NOT EXISTS datang2025 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    alamat TEXT,
    tanggal_datang DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabel datang2025 berhasil dibuat.<br>";
}

// Buat tabel pindah2024
$sql = "CREATE TABLE IF NOT EXISTS pindah2024 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    alamat_asal TEXT,
    alamat_tujuan TEXT,
    tanggal_pindah DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabel pindah2024 berhasil dibuat.<br>";
}

// Buat tabel pindah2025
$sql = "CREATE TABLE IF NOT EXISTS pindah2025 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    alamat_asal TEXT,
    alamat_tujuan TEXT,
    tanggal_pindah DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabel pindah2025 berhasil dibuat.<br>";
}

// Insert sample data
$conn->query("INSERT IGNORE INTO datang2024 (nama, alamat, tanggal_datang) VALUES 
    ('Ahmad Susanto', 'Jl. Merdeka No. 1', '2024-01-15'),
    ('Siti Nurhaliza', 'Jl. Sudirman No. 25', '2024-03-10'),
    ('Budi Santoso', 'Jl. Diponegoro No. 8', '2024-06-20')");

$conn->query("INSERT IGNORE INTO datang2025 (nama, alamat, tanggal_datang) VALUES 
    ('Rina Handayani', 'Jl. Pahlawan No. 12', '2025-02-05'),
    ('Dedi Kurniawan', 'Jl. Kartini No. 7', '2025-04-18'),
    ('Maya Sari', 'Jl. Gajah Mada No. 30', '2025-07-22')");

$conn->query("INSERT IGNORE INTO pindah2024 (nama, alamat_asal, alamat_tujuan, tanggal_pindah) VALUES 
    ('Joko Widodo', 'Jl. Thamrin No. 5', 'Jl. Kebon Jeruk No. 15', '2024-02-28'),
    ('Ani Setiawan', 'Jl. Cikini No. 20', 'Jl. Menteng No. 10', '2024-05-15'),
    ('Rudi Hermawan', 'Jl. Senayan No. 3', 'Jl. Kemang No. 45', '2024-08-10')");

$conn->query("INSERT IGNORE INTO pindah2025 (nama, alamat_asal, alamat_tujuan, tanggal_pindah) VALUES 
    ('Lisa Permata', 'Jl. Kuningan No. 8', 'Jl. Pondok Indah No. 22', '2025-01-20'),
    ('Andi Prasetyo', 'Jl. Pancoran No. 14', 'Jl. Tebet No. 33', '2025-03-25'),
    ('Dewi Sartika', 'Jl. Cempaka No. 6', 'Jl. Melati No. 18', '2025-06-12')");

echo "<br>Sample data berhasil ditambahkan!<br>";
echo "<a href='rekapitulasi.php'>Lihat Rekapitulasi</a>";

$conn->close();
?>