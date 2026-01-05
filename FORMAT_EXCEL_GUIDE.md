# Format Upload Excel - Disdukcapil System

## Format DATANG (29 Kolom)

Format ini berlaku untuk semua tahun (2024, 2025, dst).

### Header Kolom:
1. NIK
2. NO_KK
3. NAMA_LENGKAP
4. NO_DATANG
5. TGL_DATANG
6. KLASIFIKASI_PINDAH
7. NO_PROP_ASAL
8. NAMA_PROP_ASAL
9. NO_KAB_ASAL
10. NAMA_KAB_ASAL
11. NO_KEC_ASAL
12. NAMA_KEC_ASAL
13. NO_KEL_ASAL
14. NAMA_KEL_ASAL
15. ALAMAT_ASAL
16. NO_RT_ASAL
17. NO_RW_ASAL
18. NO_PROP_TUJUAN
19. NAMA_PROP_TUJUAN
20. NO_KAB_TUJUAN
21. NAMA_KAB_TUJUAN
22. NO_KEC_TUJUAN
23. NAMA_KEC_TUJUAN
24. NO_KEL_TUJUAN
25. NAMA_KEL_TUJUAN
26. ALAMAT_TUJUAN
27. NO_RT_TUJUAN
28. NO_RW_TUJUAN
29. KODE

### Template File:
Download: `template_datang_standard.csv`

---

## Format PINDAH (32 Kolom)

Format ini berlaku untuk semua tahun (2024, 2025, dst).

### Header Kolom:
1. NIK
2. NO_KK
3. NAMA_LENGKAP
4. NO_PINDAH
5. TGL_PINDAH
6. JENIS_PINDAH
7. KLASIFIKASI_PINDAH
8. KLASIFIKASI_PINDAH_KET
9. ALASAN_PINDAH
10. NO_PROP_ASAL
11. NAMA_PROP_ASAL
12. NO_KAB_ASAL
13. NAMA_KAB_ASAL
14. NO_KEC_ASAL
15. NAMA_KEC_ASAL
16. NO_KEL_ASAL
17. NAMA_KEL_ASAL
18. ALAMAT_ASAL
19. NO_RT_ASAL
20. NO_RW_ASAL
21. NO_PROP_TUJUAN
22. NAMA_PROP_TUJUAN
23. NO_KAB_TUJUAN
24. NAMA_KAB_TUJUAN
25. NO_KEC_TUJUAN
26. NAMA_KEC_TUJUAN
27. NO_KEL_TUJUAN
28. NAMA_KEL_TUJUAN
29. ALAMAT_TUJUAN
30. NO_RT_TUJUAN
31. NO_RW_TUJUAN
32. KODE

### Template File:
Download: `template_pindah_standard.csv`

---

## Catatan Penting:

1. **Format Tanggal**: 
   - Format yang didukung: `YYYY-MM-DD`, `DD/MM/YYYY`, `DD-MM-YYYY`
   - Contoh: `2024-01-15` atau `15/01/2024`

2. **Kode Wilayah**:
   - NO_PROP: 2 digit (contoh: `32`)
   - NO_KAB: 4 digit (contoh: `3201`)
   - NO_KEC: 7 digit (contoh: `3201010`)
   - NO_KEL: 10 digit (contoh: `3201010001`)

3. **File Format**:
   - Ekstensi yang didukung: `.csv`, `.xlsx`, `.xls`
   - Encoding: UTF-8
   - Maksimal ukuran file: 40MB

4. **Urutan Kolom**:
   - Urutan header harus SAMA PERSIS dengan format di atas
   - Kolom tidak boleh dikurangi atau ditambah
   - Nama header harus menggunakan HURUF KAPITAL

5. **Konsistensi Tahun**:
   - Format yang sama digunakan untuk semua tahun
   - Pilih tahun saat upload (2024, 2025, dst)
   - Data akan masuk ke tabel sesuai tahun yang dipilih

## Cara Upload:

1. Persiapkan file Excel/CSV dengan format yang sesuai
2. Pastikan header kolom sesuai dengan format standar
3. Pilih jenis data (Datang/Pindah) di form upload
4. Pilih tahun data
5. Upload file
6. Sistem akan otomatis memvalidasi dan memasukkan data

## Troubleshooting:

**Error: "Jumlah kolom tidak sesuai"**
- Pastikan jumlah kolom sesuai (29 untuk datang, 32 untuk pindah)
- Jangan hapus atau tambah kolom

**Error: "Kolom tidak sesuai"**
- Periksa nama header, harus sama persis (case-sensitive)
- Gunakan template yang disediakan

**Error validasi tanggal**
- Pastikan format tanggal sesuai
- Gunakan format YYYY-MM-DD untuk hasil terbaik
