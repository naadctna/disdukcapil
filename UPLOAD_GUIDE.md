# PANDUAN UPLOAD CSV YANG BENAR

## 📋 Format CSV yang Harus Digunakan:

### Header (Baris Pertama) - HARUS PERSIS seperti ini:
```
nama,alamat,tanggal_datang
```

### Contoh Data (Baris berikutnya):
```
John Smith,Jl. Merdeka No. 123 Jakarta,2025-11-17
Maria Garcia,Jl. Sudirman No. 456 Bandung,2025-11-16
Ahmad Rahman,Jl. Diponegoro No. 789 Surabaya,2025-11-15
```

## ✅ File Test Sudah Disiapkan:
- File: `public/test_upload_clean.csv`
- Format: UTF-8, no BOM
- Headers: nama,alamat,tanggal_datang
- 3 contoh data valid

## 🚀 Langkah Upload:
1. Buka website: http://localhost/disdukcapil/upload-excel
2. Pilih file: test_upload_clean.csv (dari folder public)
3. Data Type: Datang
4. Year: 2025
5. Klik Upload

## 🔍 Cara Cek Hasil:
1. Buka: http://localhost/disdukcapil/penduduk
2. Lihat data terbaru di tabel
3. Harusnya muncul: John Smith, Maria Garcia, Ahmad Rahman

## ⚠️ Jika Masih "Tidak Diketahui":
- Pastikan headers persis: `nama,alamat,tanggal_datang` (huruf kecil, no space)
- File encoding UTF-8
- No extra commas atau quotes
- Tanggal format: YYYY-MM-DD

## 📞 Debug:
Jika masih bermasalah, cek file log Laravel di storage/logs/laravel.log