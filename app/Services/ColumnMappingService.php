<?php

namespace App\Services;

class ColumnMappingService 
{
    /**
     * Master mapping untuk sinkronisasi Excel headers dengan database columns dan labels
     * Format UNIFIED untuk kemudahan maintenance
     */
    public static function getExcelToDbMapping($dataType = 'datang')
    {
        if ($dataType === 'datang') {
            return [
            // Index Excel => [database_column, label_display, excel_header]
            0 => ['nik', 'NIK', 'NIK'],
            1 => ['no_kk', 'No. KK', 'NO_KK'],
            2 => ['nama_lengkap', 'Nama Lengkap', 'NAMA_LENGKAP'],
            3 => ['no_datang', 'No. Datang', 'NO_DATANG'],
            4 => ['tgl_datang', 'Tanggal Datang', 'TGL_DATANG'],
            5 => ['klasifikasi_pindah', 'Klasifikasi Pindah', 'KLASIFIKASI_PINDAH'],
            6 => ['no_prop_asal', 'Kode Provinsi Asal', 'NO_PROP_ASAL'],
            7 => ['nama_prop_asal', 'Nama Provinsi Asal', 'NAMA_PROP_ASAL'],
            8 => ['no_kab_asal', 'Kode Kabupaten Asal', 'NO_KAB_ASAL'],
            9 => ['nama_kab_asal', 'Nama Kabupaten Asal', 'NAMA_KAB_ASAL'],
            10 => ['no_kec_asal', 'Kode Kecamatan Asal', 'NO_KEC_ASAL'],
            11 => ['nama_kec_asal', 'Nama Kecamatan Asal', 'NAMA_KEC_ASAL'],
            12 => ['no_kel_asal', 'Kode Kelurahan Asal', 'NO_KEL_ASAL'],
            13 => ['nama_kel_asal', 'Nama Kelurahan Asal', 'NAMA_KEL_ASAL'],
            14 => ['alamat_asal', 'Alamat Lengkap Asal', 'ALAMAT_ASAL'],
            15 => ['no_rt_asal', 'No. RT Asal', 'NO_RT_ASAL'],
            16 => ['no_rw_asal', 'No. RW Asal', 'NO_RW_ASAL'],
            17 => ['no_prop_tujuan', 'Kode Provinsi Tujuan', 'NO_PROP_TUJUAN'],
            18 => ['nama_prop_tujuan', 'Nama Provinsi Tujuan', 'NAMA_PROP_TUJUAN'],
            19 => ['no_kab_tujuan', 'Kode Kabupaten Tujuan', 'NO_KAB_TUJUAN'],
            20 => ['nama_kab_tujuan', 'Nama Kabupaten Tujuan', 'NAMA_KAB_TUJUAN'],
            21 => ['no_kec_tujuan', 'Kode Kecamatan Tujuan', 'NO_KEC_TUJUAN'],
            22 => ['nama_kec_tujuan', 'Nama Kecamatan Tujuan', 'NAMA_KEC_TUJUAN'],
            23 => ['no_kel_tujuan', 'Kode Kelurahan Tujuan', 'NO_KEL_TUJUAN'],
            24 => ['nama_kel_tujuan', 'Nama Kelurahan Tujuan', 'NAMA_KEL_TUJUAN'],
            25 => ['alamat_tujuan', 'Alamat Lengkap Tujuan', 'ALAMAT_TUJUAN'],
            26 => ['no_rt_tujuan', 'No. RT Tujuan', 'NO_RT_TUJUAN'],
            27 => ['no_rw_tujuan', 'No. RW Tujuan', 'NO_RW_TUJUAN'],
                28 => ['kode', 'Kode Referensi', 'KODE']
            ];
        } elseif ($dataType === 'pindah') {
            // PINDAH format (32 kolom) - SAMA untuk 2024 dan 2025, include required fields
            return [
                0 => ['nik', 'NIK', 'NIK'],
                1 => ['no_kk', 'No. KK', 'NO_KK'],
                2 => ['nama_lengkap', 'Nama Lengkap', 'NAMA_LENGKAP'],
                3 => ['no_pindah', 'No. Pindah', 'NO_PINDAH'],
                4 => ['tgl_pindah', 'Tanggal Pindah', 'TGL_PINDAH'],
                5 => ['jenis_pindah', 'Jenis Pindah', 'JENIS_PINDAH'],
                6 => ['klasifikasi_pindah', 'Klasifikasi Pindah', 'KLASIFIKASI_PINDAH'],
                7 => ['klasifikasi_pindah_ket', 'Keterangan Klasifikasi', 'KLASIFIKASI_PINDAH_KET'],
                8 => ['alasan_pindah', 'Alasan Pindah', 'ALASAN_PINDAH'],
                9 => ['no_prop_asal', 'Kode Provinsi Asal', 'NO_PROP_ASAL'],
                10 => ['nama_prop_asal', 'Nama Provinsi Asal', 'NAMA_PROP_ASAL'],
                11 => ['no_kab_asal', 'Kode Kabupaten Asal', 'NO_KAB_ASAL'],
                12 => ['nama_kab_asal', 'Nama Kabupaten Asal', 'NAMA_KAB_ASAL'],
                13 => ['no_kec_asal', 'Kode Kecamatan Asal', 'NO_KEC_ASAL'],
                14 => ['nama_kec_asal', 'Nama Kecamatan Asal', 'NAMA_KEC_ASAL'],
                15 => ['no_kel_asal', 'Kode Kelurahan Asal', 'NO_KEL_ASAL'],
                16 => ['nama_kel_asal', 'Nama Kelurahan Asal', 'NAMA_KEL_ASAL'],
                17 => ['alamat_asal', 'Alamat Lengkap Asal', 'ALAMAT_ASAL'],
                18 => ['no_rt_asal', 'No. RT Asal', 'NO_RT_ASAL'],
                19 => ['no_rw_asal', 'No. RW Asal', 'NO_RW_ASAL'],
                20 => ['no_prop_tujuan', 'Kode Provinsi Tujuan', 'NO_PROP_TUJUAN'],
                21 => ['nama_prop_tujuan', 'Nama Provinsi Tujuan', 'NAMA_PROP_TUJUAN'],
                22 => ['no_kab_tujuan', 'Kode Kabupaten Tujuan', 'NO_KAB_TUJUAN'],
                23 => ['nama_kab_tujuan', 'Nama Kabupaten Tujuan', 'NAMA_KAB_TUJUAN'],
                24 => ['no_kec_tujuan', 'Kode Kecamatan Tujuan', 'NO_KEC_TUJUAN'],
                25 => ['nama_kec_tujuan', 'Nama Kecamatan Tujuan', 'NAMA_KEC_TUJUAN'],
                26 => ['no_kel_tujuan', 'Kode Kelurahan Tujuan', 'NO_KEL_TUJUAN'],
                27 => ['nama_kel_tujuan', 'Nama Kelurahan Tujuan', 'NAMA_KEL_TUJUAN'],
                28 => ['alamat_tujuan', 'Alamat Lengkap Tujuan', 'ALAMAT_TUJUAN'],
                29 => ['no_rt_tujuan', 'No. RT Tujuan', 'NO_RT_TUJUAN'],
                30 => ['no_rw_tujuan', 'No. RW Tujuan', 'NO_RW_TUJUAN'],
                31 => ['kode', 'Kode Referensi', 'KODE']
            ];
        }
        
        return [];
    }

    /**
     * Get database column mapping (untuk ExcelUploadController)
     */
    public static function getDbColumnMapping($dataType = 'datang')
    {
        $mapping = [];
        foreach (self::getExcelToDbMapping($dataType) as $index => $data) {
            $mapping[$index] = $data[0]; // database column
        }
        return $mapping;
    }

    /**
     * Get field labels (untuk display di frontend)
     */
    public static function getFieldLabels($dataType = 'datang')
    {
        $labels = [];
        foreach (self::getExcelToDbMapping($dataType) as $index => $data) {
            $labels[$data[0]] = $data[1]; // database_column => label
        }
        
        // Add system fields
        $labels['id'] = 'ID';
        $labels['created_at'] = 'Dibuat';
        $labels['updated_at'] = 'Diperbarui';
        
        return $labels;
    }

    /**
     * Get Excel headers (untuk validasi template)
     */
    public static function getExcelHeaders($dataType = 'datang')
    {
        $headers = [];
        foreach (self::getExcelToDbMapping($dataType) as $index => $data) {
            $headers[] = $data[2]; // excel header
        }
        return $headers;
    }

    /**
     * Validate Excel headers against expected template
     */
    public static function validateExcelHeaders($uploadedHeaders, $dataType = 'datang')
    {
        $expectedHeaders = self::getExcelHeaders($dataType);
        $errors = [];
        
        if (count($uploadedHeaders) !== count($expectedHeaders)) {
            $errors[] = "Jumlah kolom tidak sesuai. Diharapkan " . count($expectedHeaders) . " kolom, ditemukan " . count($uploadedHeaders);
        }
        
        foreach ($expectedHeaders as $index => $expectedHeader) {
            if (!isset($uploadedHeaders[$index])) {
                $errors[] = "Kolom ke-" . ($index + 1) . " hilang: {$expectedHeader}";
            } elseif (trim(strtoupper($uploadedHeaders[$index])) !== strtoupper($expectedHeader)) {
                $errors[] = "Kolom ke-" . ($index + 1) . " tidak sesuai. Diharapkan '{$expectedHeader}', ditemukan '{$uploadedHeaders[$index]}'";
            }
        }
        
        return $errors;
    }

    /**
     * Get field grouping untuk tampilan yang lebih terorganisir dan berurutan
     */
    public static function getFieldGroups($dataType = 'datang')
    {
        if ($dataType === 'datang') {
            return [
                'Data Utama' => ['id', 'nik', 'no_kk', 'nama_lengkap', 'no_datang', 'tgl_datang', 'klasifikasi_pindah'],
                'Alamat Asal' => [
                    'no_prop_asal', 'nama_prop_asal', 'no_kab_asal', 'nama_kab_asal', 
                    'no_kec_asal', 'nama_kec_asal', 'no_kel_asal', 'nama_kel_asal', 
                    'alamat_asal', 'no_rt_asal', 'no_rw_asal'
                ],
                'Alamat Tujuan' => [
                    'no_prop_tujuan', 'nama_prop_tujuan', 'no_kab_tujuan', 'nama_kab_tujuan',
                    'no_kec_tujuan', 'nama_kec_tujuan', 'no_kel_tujuan', 'nama_kel_tujuan',
                    'alamat_tujuan', 'no_rt_tujuan', 'no_rw_tujuan'
                ],
                'Informasi Sistem' => ['kode', 'created_at', 'updated_at']
            ];
        } elseif ($dataType === 'pindah') {
            return [
                'Data Utama' => ['id', 'nik', 'no_kk', 'nama_lengkap', 'no_pindah', 'tgl_pindah', 'jenis_pindah', 'klasifikasi_pindah', 'klasifikasi_pindah_ket', 'alasan_pindah'],
                'Alamat Asal' => [
                    'no_prop_asal', 'nama_prop_asal', 'no_kab_asal', 'nama_kab_asal',
                    'no_kec_asal', 'nama_kec_asal', 'no_kel_asal', 'nama_kel_asal', 
                    'alamat_asal', 'no_rt_asal', 'no_rw_asal'
                ],
                'Alamat Tujuan' => [
                    'no_prop_tujuan', 'nama_prop_tujuan', 'no_kab_tujuan', 'nama_kab_tujuan',
                    'no_kec_tujuan', 'nama_kec_tujuan', 'no_kel_tujuan', 'nama_kel_tujuan', 
                    'alamat_tujuan', 'no_rt_tujuan', 'no_rw_tujuan'
                ],
                'Informasi Sistem' => ['kode', 'created_at', 'updated_at']
            ];
        }
        
        return [];
    }

    /**
     * Get ordered display sequence untuk mencegah kesalahan pemanggilan data
     */
    public static function getDisplayOrder($dataType = 'datang')
    {
        $order = [];
        $groups = self::getFieldGroups($dataType);
        
        foreach ($groups as $groupName => $fields) {
            $order = array_merge($order, $fields);
        }
        
        return $order;
    }

    /**
     * Get formatted display data dengan urutan yang konsisten
     */
    public static function formatDisplayData($rawData, $dataType = 'datang')
    {
        $labels = self::getFieldLabels($dataType);
        $order = self::getDisplayOrder($dataType);
        $formatted = [];
        
        foreach ($order as $field) {
            if (isset($rawData->$field) && $rawData->$field !== null && $rawData->$field !== '') {
                $formatted[] = [
                    'field' => $field,
                    'label' => $labels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'value' => $rawData->$field
                ];
            }
        }
        
        return $formatted;
    }
}