<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExcelUploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload-excel');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
            'data_type' => 'required|in:datang,pindah',
            'year' => 'required|in:2024,2025'
        ]);

        try {
            $file = $request->file('excel_file');
            $dataType = $request->input('data_type');
            $year = $request->input('year');
            
            // Tentukan nama tabel berdasarkan input
            $tableName = $dataType . $year;
            
            $results = $this->processExcelFile($file, $tableName, $dataType);
            
            return back()->with('success', "Data berhasil diupload! {$results['inserted']} records ditambahkan, {$results['errors']} errors.")->with('upload_results', $results);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    private function processExcelFile($file, $tableName, $dataType)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => []
        ];

        // Baca file sebagai CSV
        if (($handle = fopen($file->getPathname(), "r")) !== FALSE) {
            $headers = [];
            $rowIndex = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($rowIndex == 0) {
                    // Baris pertama adalah header
                    $headers = array_map('trim', $data);
                    $rowIndex++;
                    continue;
                }

                try {
                    $rowData = $this->mapRowData($headers, $data, $dataType);
                    
                    if ($this->validateRowData($rowData, $dataType)) {
                        DB::table($tableName)->insert($rowData);
                        $results['inserted']++;
                        
                        // Simpan 5 data pertama untuk preview
                        if (count($results['preview']) < 5) {
                            $results['preview'][] = $rowData;
                        }
                    } else {
                        $results['errors']++;
                        $results['error_details'][] = "Row {$rowIndex}: Invalid data format";
                    }
                } catch (\Exception $e) {
                    $results['errors']++;
                    $results['error_details'][] = "Row {$rowIndex}: " . $e->getMessage();
                }

                $rowIndex++;
            }
            fclose($handle);
        }

        return $results;
    }

    private function mapRowData($headers, $data, $dataType)
    {
        $mapped = [];
        
        // Map common fields
        for ($i = 0; $i < count($headers); $i++) {
            $header = strtolower(trim($headers[$i]));
            $value = isset($data[$i]) ? trim($data[$i]) : '';
            
            // Map header ke kolom database
            switch ($header) {
                case 'nama':
                case 'nama_lengkap':
                case 'name':
                    $mapped['NAMA_LENGKAP'] = $value;
                    break;
                    
                case 'alamat':
                case 'alamat_tujuan':
                case 'address':
                    if ($dataType == 'datang') {
                        $mapped['ALAMAT_TUJUAN'] = $value;
                    } else {
                        $mapped['ALAMAT_ASAL'] = $value;
                    }
                    break;
                    
                case 'alamat_asal':
                case 'alamat_sebelumnya':
                    $mapped['ALAMAT_ASAL'] = $value;
                    break;
                    
                case 'alamat_tujuan':
                case 'alamat_baru':
                    $mapped['ALAMAT_TUJUAN'] = $value;
                    break;
                    
                case 'tanggal':
                case 'tanggal_datang':
                case 'tgl_datang':
                case 'date':
                    $mapped['TGL_DATANG'] = $this->formatDate($value);
                    break;
                    
                case 'tanggal_pindah':
                case 'tgl_pindah':
                    $mapped['TGL_PINDAH'] = $this->formatDate($value);
                    break;
            }
        }
        
        return $mapped;
    }

    private function validateRowData($data, $dataType)
    {
        // Validasi field wajib
        if (empty($data['NAMA_LENGKAP'])) {
            return false;
        }
        
        if ($dataType == 'datang') {
            return !empty($data['ALAMAT_TUJUAN']) && !empty($data['TGL_DATANG']);
        } else {
            return !empty($data['ALAMAT_ASAL']) && !empty($data['TGL_PINDAH']);
        }
    }

    private function formatDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        
        try {
            // Coba berbagai format tanggal
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d'];
            
            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $dateString);
                if ($date && $date->format($format) == $dateString) {
                    return $date->format('Y-m-d');
                }
            }
            
            // Fallback ke strtotime
            $timestamp = strtotime($dateString);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
            
        } catch (\Exception $e) {
            // Return null jika parsing gagal
        }
        
        return null;
    }

    public function downloadTemplate(Request $request)
    {
        $type = $request->get('type', 'datang');
        
        if ($type == 'datang') {
            $headers = ['nama_lengkap', 'alamat_tujuan', 'tanggal_datang'];
            $sample = ['John Doe', 'Jl. Merdeka No. 123', '2025-01-15'];
        } else {
            $headers = ['nama_lengkap', 'alamat_asal', 'alamat_tujuan', 'tanggal_pindah'];
            $sample = ['Jane Smith', 'Jl. Sudirman No. 456', 'Jl. Thamrin No. 789', '2025-01-20'];
        }

        $filename = "template_{$type}.csv";
        
        $callback = function() use ($headers, $sample) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, $sample);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}