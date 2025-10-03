# Template Excel untuk Upload Data Penduduk

## Cara Menggunakan:

1. **Download Template**
   - Download template Excel dari halaman upload
   - Ada 2 template: Penduduk Datang dan Penduduk Pindah

2. **Format Template Penduduk Datang:**
   ```
   nama_lengkap | alamat_tujuan | tanggal_datang
   John Doe     | Jl. Merdeka No. 123 | 2025-01-15
   ```

3. **Format Template Penduduk Pindah:**
   ```
   nama_lengkap | alamat_asal | alamat_tujuan | tanggal_pindah  
   Jane Smith   | Jl. Sudirman No. 456 | Jl. Thamrin No. 789 | 2025-01-20
   ```

4. **Format Tanggal yang Didukung:**
   - Y-m-d (2025-01-15)
   - d/m/Y (15/01/2025)  
   - m/d/Y (01/15/2025)
   - d-m-Y (15-01-2025)
   - Y/m/d (2025/01/15)

5. **Aturan Upload:**
   - File maksimal 10MB
   - Format: CSV, XLSX, XLS
   - Baris pertama adalah header
   - Field nama_lengkap wajib diisi
   - Field alamat dan tanggal wajib diisi sesuai jenis data

6. **Hasil Upload:**
   - Sistem akan menampilkan ringkasan upload
   - Jumlah data berhasil dan error
   - Preview 5 data pertama yang berhasil
   - Detail error jika ada

## Fitur:
✅ Auto-detect format tanggal
✅ Validasi data real-time  
✅ Error reporting lengkap
✅ Preview hasil upload
✅ Drag & drop file
✅ Template download
✅ Bulk import ke database