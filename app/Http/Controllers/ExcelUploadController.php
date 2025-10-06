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
        \Log::info('Upload started with data: ' . json_encode($request->all()));
        
        try {
            // Custom validation untuk file
            $request->validate([
                'excel_file' => 'required|file|max:10240', // Basic file validation only
                'data_type' => 'required|in:datang,pindah',
                'year' => 'required|in:2024,2025'
            ]);
            
            // Manual file type validation
            $file = $request->file('excel_file');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['csv', 'xlsx', 'xls', 'txt'];
            
            if (!in_array($extension, $allowedExtensions)) {
                return back()->withErrors(['excel_file' => 'File harus berformat CSV, XLSX, XLS, atau TXT'])->withInput();
            }
            
            \Log::info('File validation passed. Extension: ' . $extension);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $file = $request->file('excel_file');
            $dataType = $request->input('data_type');
            $year = $request->input('year');
            
            // Tentukan nama tabel berdasarkan input
            $tableName = $dataType . $year;
            
            // Check file type and convert if needed
            $fileExtension = strtolower($file->getClientOriginalExtension());
            if (in_array($fileExtension, ['xlsx', 'xls'])) {
                $convertMessage = 'File Excel (.xlsx/.xls) perlu diconvert ke CSV terlebih dahulu. Ikuti langkah berikut:<br><br>';
                $convertMessage .= '<strong>Cara Convert Excel ke CSV:</strong><br>';
                $convertMessage .= '1. Buka file Excel Anda<br>';
                $convertMessage .= '2. Klik <strong>File</strong> → <strong>Save As</strong><br>';
                $convertMessage .= '3. Pada "Save as type", pilih <strong>CSV (Comma delimited) (*.csv)</strong><br>';
                $convertMessage .= '4. Klik <strong>Save</strong><br>';
                $convertMessage .= '5. Upload ulang file .csv yang sudah diconvert<br><br>';
                $convertMessage .= '<em>Atau download template CSV di atas untuk format yang sudah benar!</em>';
                
                return back()->with('error', $convertMessage);
            }
            
            $results = $this->processExcelFile($file, $tableName, $dataType);
            
            $message = "Data berhasil diupload! {$results['inserted']} records ditambahkan, {$results['errors']} errors.";
            if ($results['errors'] > 0) {
                if (!empty($results['debug_headers'])) {
                    $message .= "\nHeaders detected: " . implode(', ', $results['debug_headers']);
                }
                if (!empty($results['error_details'])) {
                    $message .= "\nDetail errors: " . implode(', ', array_slice($results['error_details'], 0, 3));
                }
            }
            return back()->with('success', $message)->with('upload_results', $results);
            
        } catch (\Exception $e) {
            \Log::error('Excel upload error: ' . $e->getMessage());
            return back()->with('error', 'Error processing file: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')');
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

        try {
            // Process CSV file only
            \Log::info('Processing CSV file: ' . $file->getClientOriginalName());
            if (($handle = fopen($file->getPathname(), "r")) !== FALSE) {
                $headers = [];
                $rowIndex = 0;

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($rowIndex == 0) {
                        // Baris pertama adalah header
                        $headers = array_map('trim', $data);
                        $results['debug_headers'] = $headers;
                        $rowIndex++;
                        continue;
                    }

                    try {
                        $rowData = $this->mapRowData($headers, $data, $dataType);
                        
                        // Debug: simpan info row data
                        if ($rowIndex <= 3) {
                            $results['debug_raw_data'][$rowIndex] = [
                                'raw_data' => $data,
                                'mapped_data' => $rowData
                            ];
                        }
                        
                        if ($this->validateRowData($rowData, $dataType)) {
                            // Tambahkan timestamp
                            $rowData['created_at'] = now();
                            $rowData['updated_at'] = now();
                            
                            DB::table($tableName)->insert($rowData);
                            $results['inserted']++;
                            
                            // Simpan 5 data pertama untuk preview
                            if (count($results['preview']) < 5) {
                                $results['preview'][] = $rowData;
                            }
                        } else {
                            $results['errors']++;
                            $debugInfo = "Row {$rowIndex}: Invalid data - " . json_encode($rowData);
                            $results['error_details'][] = $debugInfo;
                        }
                    } catch (\Exception $e) {
                        $results['errors']++;
                        $results['error_details'][] = "Row {$rowIndex}: " . $e->getMessage();
                    }

                    $rowIndex++;
                }
                fclose($handle);
            }
        } catch (\Exception $e) {
            $results['errors']++;
            $results['error_details'][] = "File processing error: " . $e->getMessage();
        }

        return $results;
    }

    private function mapRowData($headers, $data, $dataType)
    {
        $mapped = [];
        
        // Map common fields
        for ($i = 0; $i < count($headers); $i++) {
            $header = strtolower(trim($headers[$i]));
            // Ganti spasi dengan underscore agar lebih fleksibel
            $header = str_replace(' ', '_', $header);
            $value = isset($data[$i]) ? trim($data[$i]) : '';
            
            // Map header ke kolom database (struktur tabel baru)
            switch ($header) {
                case 'nama':
                case 'nama_lengkap':
                case 'name':
                    $mapped['nama'] = $value;
                    break;
                    
                case 'alamat':
                case 'address':
                    if ($dataType == 'datang') {
                        $mapped['alamat'] = $value;
                    }
                    break;
                    
                case 'alamat_asal':
                case 'alamat_sebelumnya':
                    $mapped['alamat_asal'] = $value;
                    break;
                    
                case 'alamat_tujuan':
                case 'alamat_baru':
                    $mapped['alamat_tujuan'] = $value;
                    break;
                    
                case 'tanggal':
                case 'tanggal_datang':
                case 'tgl_datang':
                case 'date':
                    $mapped['tanggal_datang'] = $this->formatDate($value);
                    break;
                    
                case 'tanggal_pindah':
                case 'tgl_pindah':
                    $mapped['tanggal_pindah'] = $this->formatDate($value);
                    break;
            }
        }
        
        return $mapped;
    }

    private function validateRowData($data, $dataType)
    {
        // Validasi field wajib (struktur tabel baru)
        if (empty($data['nama'])) {
            return false;
        }
        
        if ($dataType == 'datang') {
            return !empty($data['alamat']) && !empty($data['tanggal_datang']);
        } else {
            return !empty($data['alamat_asal']) && !empty($data['alamat_tujuan']) && !empty($data['tanggal_pindah']);
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
}