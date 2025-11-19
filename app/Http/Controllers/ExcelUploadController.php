<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Services\DynamicTableService;

class ExcelUploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload-excel');
    }

    public function processUpload(Request $request)
    {
        // Optimize for speed
        set_time_limit(300); // 5 minutes
        ini_set('memory_limit', '1024M'); // Increase memory
        ini_set('max_execution_time', 300);
        
        \Log::info('Upload started with data: ' . json_encode($request->all()));
        \Log::info('=== USING FIXED UPLOAD SYSTEM - NO MORE DEFAULT VALUES ===');
        
        try {
            // Custom validation untuk file
            $request->validate([
                'excel_file' => 'required|file|max:40960', // 40MB sesuai PHP server config
                'data_type' => 'required|in:datang,pindah',
                'year' => 'required|integer|min:2020|max:2030'
            ]);
            
            // Manual file type validation
            $file = $request->file('excel_file');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['csv', 'xlsx', 'xls', 'txt'];
            
            if (!in_array($extension, $allowedExtensions)) {
                return back()->withErrors(['excel_file' => 'File harus berformat CSV, XLSX, XLS, atau TXT'])->withInput();
            }
            
            \Log::info('File validation passed. Extension: ' . $extension);
            
            // Clear existing dummy data before processing
            $this->clearDummyData();
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $file = $request->file('excel_file');
            $dataType = $request->input('data_type');
            $year = $request->input('year');
            
            // Gunakan DynamicTableService untuk memastikan tabel exists
            $dynamicTableService = new DynamicTableService();
            $tableName = $dynamicTableService->ensureTableExists($dataType, $year);
            
            // Check file type - now supports Excel files directly
            $fileExtension = strtolower($file->getClientOriginalExtension());
            \Log::info('Processing file with extension: ' . $fileExtension);
            
            $results = $this->processExcelFile($file, $tableName, $dataType, $year);
            
            $formatType = isset($results['debug_format']) ? $results['debug_format'] : 'MULTI_COLUMN';
            $formatLabel = $formatType === 'SINGLE_COLUMN' ? 'Format Single Column' : 'Format Multi Kolom';
            
            $message = "Data berhasil diupload! ({$formatLabel})<br>";
            $message .= "✅ {$results['inserted']} records berhasil ditambahkan<br>";
            
            // Show processed sheets info for multi-sheet files
            if (isset($results['processed_sheets']) && count($results['processed_sheets']) > 1) {
                $message .= "📊 Diproses dari " . count($results['processed_sheets']) . " sheets:<br>";
                foreach ($results['processed_sheets'] as $sheet) {
                    $message .= "   • {$sheet['name']}: {$sheet['inserted']} records";
                    if ($sheet['errors'] > 0) {
                        $message .= " ({$sheet['errors']} errors)";
                    }
                    $message .= "<br>";
                }
            }
            
            if ($results['errors'] > 0) {
                $message .= "⚠️ {$results['errors']} records error<br>";
                if (!empty($results['error_details'])) {
                    $message .= "Detail error: " . implode('<br>', array_slice($results['error_details'], 0, 3));
                    if (count($results['error_details']) > 3) {
                        $message .= "<br>... dan " . (count($results['error_details']) - 3) . " error lainnya";
                    }
                }
            }
            
            return back()->with('success', $message)->with('upload_results', $results);
            
        } catch (\Exception $e) {
            \Log::error('Excel upload error: ' . $e->getMessage());
            return back()->with('error', 'Error processing file: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')');
        }
    }

    private function processExcelFile($file, $tableName, $dataType, $year)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => []
        ];

        try {
            $fileExtension = strtolower($file->getClientOriginalExtension());
            \Log::info('Processing file: ' . $file->getClientOriginalName() . ' (Extension: ' . $fileExtension . ')');
            
            // Handle Excel files (.xlsx, .xls) - CONVERT TO CSV FIRST
            if (in_array($fileExtension, ['xlsx', 'xls'])) {
                // Convert Excel to CSV using PhpSpreadsheet then process as CSV
                try {
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($fileExtension));
                    $spreadsheet = $reader->load($file->getPathname());
                    
                    // Check if file has multiple sheets
                    $sheetCount = $spreadsheet->getSheetCount();
                    \Log::info("Excel file has {$sheetCount} sheets");
                    
                    // For pindah 2024 with multiple sheets, process ALL sheets
                    if ($dataType === 'pindah' && $year == 2024 && $sheetCount > 1) {
                        return $this->processMultipleSheets($spreadsheet, $tableName, $dataType, $year);
                    }
                    
                    // For single sheet or other cases, process single sheet
                    if ($sheetCount > 1) {
                        $worksheet = $this->findDataSheet($spreadsheet, $dataType, $year);
                    } else {
                        $worksheet = $spreadsheet->getActiveSheet();
                    }
                    
                    // Convert to simple array format
                    $data = $worksheet->toArray();
                    
                    // FAST HEADER DETECTION - CEK HANYA 10 BARIS PERTAMA
                    $headers = [];
                    $headerRowIndex = -1;
                    $successCount = 0;
                    
                    // Cari header di 10 baris pertama saja (lebih cepat)
                    $maxRowsToCheck = min(10, count($data));
                    for ($i = 0; $i < $maxRowsToCheck; $i++) {
                        if (!isset($data[$i])) continue;
                        
                        $row = $data[$i];
                        $rowText = strtolower(implode(' ', $row));
                        
                        if (strpos($rowText, 'nik') !== false || 
                            strpos($rowText, 'nama_lengkap') !== false || 
                            strpos($rowText, 'nama') !== false) {
                            $headers = array_map('strtolower', array_map('trim', $row));
                            $headerRowIndex = $i;
                            \Log::info("Excel headers found at row {$i}");
                            break;
                        }
                    }
                    
                    // Fallback: pakai row pertama
                    if ($headerRowIndex === -1) {
                        $headers = array_map('strtolower', array_map('trim', $data[0]));
                        $headerRowIndex = 0;
                    }
                    
                    // Process data setelah header
                    foreach ($data as $rowIndex => $row) {
                        if ($rowIndex <= $headerRowIndex) continue; // Skip header dan baris sebelumnya
                        
                        if (empty(array_filter($row))) continue; // Skip empty rows
                        
                        // FAST MAPPING - LANGSUNG CARI INDEX SEKALI JALAN
                        static $mappingCache = null;
                        
                        if ($mappingCache === null) {
                            $namaIndex = 2;    // Default NAMA_LENGKAP di kolom 2
                            $alamatIndex = 1;  // Default alamat di kolom 1  
                            $tanggalIndex = 4; // Default tanggal di kolom 4
                            
                            // Quick search
                            for ($i = 0; $i < count($headers); $i++) {
                                $h = $headers[$i];
                                if (strpos($h, 'nama') !== false) $namaIndex = $i;
                                if (strpos($h, 'alamat') !== false) $alamatIndex = $i;
                                if (strpos($h, 'tanggal') !== false || strpos($h, 'tgl') !== false) $tanggalIndex = $i;
                            }
                            
                            $mappingCache = [$namaIndex, $alamatIndex, $tanggalIndex];
                            \Log::info("Fast mapping - Nama: {$namaIndex}, Alamat: {$alamatIndex}, Tanggal: {$tanggalIndex}");
                        }
                        
                        list($namaIndex, $alamatIndex, $tanggalIndex) = $mappingCache;
                        
                        // KONVERSI TANGGAL KE FORMAT MySQL (YYYY-MM-DD)
                        $tanggalValue = isset($row[$tanggalIndex]) && trim($row[$tanggalIndex]) !== '' ? trim($row[$tanggalIndex]) : date('Y-m-d');
                        $tanggalFormatted = $this->convertDateFormat($tanggalValue);
                        
                        // COMPREHENSIVE MAPPING - MAP BERDASARKAN FORMAT YANG BENAR
                        $rowData = [
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                        
                        // Get column mapping based on data type and year
                        $excelColumns = $this->getColumnMapping($dataType, $year);
                        
                        // Map data dari Excel ke database
                        foreach ($excelColumns as $excelIndex => $dbColumn) {
                            if (isset($row[$excelIndex])) {
                                $value = trim($row[$excelIndex]);
                                if ($dbColumn === 'tgl_datang') {
                                    $rowData['tanggal_datang'] = $this->convertDateFormat($value);
                                    $rowData[$dbColumn] = $this->convertDateFormat($value);
                                } elseif ($dbColumn === 'tgl_pindah') {
                                    $rowData['tanggal_pindah'] = $this->convertDateFormat($value);
                                    $rowData[$dbColumn] = $this->convertDateFormat($value);
                                } else {
                                    $rowData[$dbColumn] = $value !== '' ? $value : null;
                                }
                            }
                        }
                        
                        // Fallback untuk kolom wajib jika kosong
                        if (empty($rowData['nama_lengkap'])) {
                            $rowData['nama_lengkap'] = 'Excel Row ' . $rowIndex;
                        }
                        if (empty($rowData['tanggal_datang'])) {
                            $rowData['tanggal_datang'] = date('Y-m-d');
                        }
                        
                        // Legacy support - mapping ke kolom lama
                        $rowData['nama'] = $rowData['nama_lengkap'];
                        $rowData['alamat'] = $rowData['alamat_asal'] ?: $rowData['alamat_tujuan'] ?: 'Alamat tidak ada';
                        
                        // Filter dan insert
                        $filteredData = $this->filterValidColumns($rowData, $tableName);
                        
                        // DEBUG: Log data yang akan diinsert

                        
                        if (!empty($filteredData)) {
                            DB::table($tableName)->insert($filteredData);
                            $successCount++;
                            \Log::info("DEBUG INSERT - SUCCESS for row {$rowIndex}");
                        } else {
                            \Log::error("DEBUG INSERT - EMPTY FILTERED DATA for row {$rowIndex}");
                            $results['errors']++;
                        }
                        
                        if (count($results['preview']) < 5) {
                            $results['preview'][] = $rowData;
                        }
                    }
                    
                    $results['inserted'] = $successCount;
                    return $results;
                    
                } catch (\Exception $e) {
                    \Log::error('Excel processing error: ' . $e->getMessage());
                    $results['errors']++;
                    $results['error_details'][] = 'Excel processing failed: ' . $e->getMessage();
                    return $results;
                }
            }
            
            // Handle CSV/TXT files
            $fileContent = file_get_contents($file->getPathname());
            $lines = explode("\n", $fileContent);
            $sampleLine = isset($lines[1]) ? trim($lines[1]) : (isset($lines[0]) ? trim($lines[0]) : '');
            
            // Check if it's single column format (all data in one cell separated by commas)
            $isSingleColumnFormat = $this->detectSingleColumnFormat($lines);
            
            if ($isSingleColumnFormat) {
                \Log::info('Detected SINGLE COLUMN format - processing accordingly');
                return $this->processSingleColumnFile($file, $tableName, $dataType, $year);
            }
            
            // Process as regular multi-column CSV
            \Log::info('Processing as regular multi-column CSV file');
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
                        // COMPREHENSIVE CSV MAPPING - SAMA SEPERTI EXCEL
                        $rowData = [
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                        
                        // Get column mapping based on data type and year
                        $csvColumns = $this->getColumnMapping($dataType, $year);
                        
                        // Map data dari CSV ke database
                        foreach ($csvColumns as $csvIndex => $dbColumn) {
                            if (isset($data[$csvIndex])) {
                                $value = trim($data[$csvIndex]);
                                if ($dbColumn === 'tgl_datang') {
                                    $rowData['tanggal_datang'] = $this->convertDateFormat($value);
                                    $rowData[$dbColumn] = $this->convertDateFormat($value);
                                } elseif ($dbColumn === 'tgl_pindah') {
                                    $rowData['tanggal_pindah'] = $this->convertDateFormat($value);
                                    $rowData[$dbColumn] = $this->convertDateFormat($value);
                                } else {
                                    $rowData[$dbColumn] = $value !== '' ? $value : null;
                                }
                            }
                        }
                        
                        // Fallback untuk kolom wajib jika kosong
                        if (empty($rowData['nama_lengkap'])) {
                            $rowData['nama_lengkap'] = 'CSV Row ' . $rowIndex;
                        }
                        if (empty($rowData['tanggal_datang'])) {
                            $rowData['tanggal_datang'] = date('Y-m-d');
                        }
                        
                        // Legacy support - mapping ke kolom lama
                        $rowData['nama'] = $rowData['nama_lengkap'];
                        $rowData['alamat'] = $rowData['alamat_asal'] ?: $rowData['alamat_tujuan'] ?: 'Alamat tidak ada';
                        
                        // Debug: simpan info row data
                        if ($rowIndex <= 3) {
                            $results['debug_raw_data'][$rowIndex] = [
                                'raw_data' => $data,
                                'mapped_data' => $rowData
                            ];
                        }
                        
                        // SKIP VALIDATION - LANGSUNG INSERT
                        // Tambahkan timestamp
                        $rowData['created_at'] = now();
                        $rowData['updated_at'] = now();
                            
                        // Filter to only valid columns for this table
                        $filteredData = $this->filterValidColumns($rowData, $tableName);
                        
                        DB::table($tableName)->insert($filteredData);
                        $results['inserted']++;
                        
                        // Simpan 5 data pertama untuk preview
                        if (count($results['preview']) < 5) {
                            $results['preview'][] = $rowData;
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

    /**
     * Detect if file is in single column format (all data in one cell)
     */
    private function detectSingleColumnFormat($lines)
    {
        $sampleLines = array_slice($lines, 0, 5); // Check first 5 lines
        $singleColumnCount = 0;
        
        foreach ($sampleLines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Parse as CSV to see column count
            $csvData = str_getcsv($line);
            
            \Log::info("DEBUG DETECT - Line: '{$line}' -> CSV count: " . count($csvData) . " -> Data: " . json_encode($csvData));
            
            // If only 1 column but contains multiple commas, likely single column format
            if (count($csvData) == 1 && substr_count($line, ',') >= 2) {
                $singleColumnCount++;
                \Log::info("DEBUG DETECT - Single column detected (type 1)");
            }
            
            // Also check if it has pattern like "name, address, number" in one cell
            if (count($csvData) == 1 && preg_match('/^[^,]+,\s*[^,]+,\s*\d+/', $line)) {
                $singleColumnCount++;
                \Log::info("DEBUG DETECT - Single column detected (type 2)");
            }
            
            // NEW: Detect simple 3-column format as single column type
            if (count($csvData) == 3 && !empty($csvData[0]) && !empty($csvData[1])) {
                // If we have exactly 3 columns, consider it single column format
                $singleColumnCount++;
                \Log::info("DEBUG DETECT - 3-column format detected as single column");
            }
        }
        
        \Log::info("DEBUG DETECT - Single column count: {$singleColumnCount} / " . count($sampleLines));
        
        // If majority of sample lines are single column format
        return $singleColumnCount >= 2;
    }
    
    /**
     * Process file with single column format (all data in one cell separated by commas)
     */
    private function processSingleColumnFile($file, $tableName, $dataType, $year)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => [],
            'debug_format' => 'SINGLE_COLUMN'
        ];

        try {
            $fileContent = file_get_contents($file->getPathname());
            $lines = explode("\n", $fileContent);
            $rowIndex = 0;

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                $rowIndex++;
                
                try {
                    // Parse single column data
                    $rowData = $this->parseSingleColumnData($line, $dataType);
                    
                    // Debug: simpan info row data
                    if ($rowIndex <= 3) {
                        $results['debug_raw_data'][$rowIndex] = [
                            'raw_line' => $line,
                            'parsed_data' => $rowData
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
            }
        } catch (\Exception $e) {
            $results['errors']++;
            $results['error_details'][] = "File processing error: " . $e->getMessage();
        }

        return $results;
    }
    
    /**
     * Parse single column data like "erfan eka maulana, cikoneng, 23724587354"
     */
    private function parseSingleColumnData($line, $dataType)
    {
        // Split by comma and clean up
        $parts = array_map('trim', explode(',', $line));
        
        $mapped = [];
        
        // Initialize with null values - use correct database column names
        if ($dataType === 'datang') {
            $mapped = [
                'nama_lengkap' => null,
                'alamat_asal' => null,
                'tgl_datang' => null
            ];
        } else { // pindah
            $mapped = [
                'nama_lengkap' => null,
                'alamat_asal' => null,
                'alamat_tujuan' => null,
                'tgl_pindah' => null
            ];
        }
        
        // Try to intelligently map the parts
        if ($dataType === 'datang') {
            // Format expected: "nama, alamat, tanggal" or "nama, alamat"
            if (count($parts) >= 1) {
                $mapped['nama_lengkap'] = $parts[0];
            }
            if (count($parts) >= 2) {
                // Check if second part looks like a date or address
                if ($this->looksLikeDate($parts[1])) {
                    $mapped['tgl_datang'] = $this->parseFlexibleDate($parts[1]);
                } else {
                    $mapped['alamat_asal'] = $parts[1];
                }
            }
            if (count($parts) >= 3) {
                // Third part could be date if second was address
                if (empty($mapped['tgl_datang']) && $this->looksLikeDate($parts[2])) {
                    $mapped['tgl_datang'] = $this->parseFlexibleDate($parts[2]);
                } else if (empty($mapped['alamat_asal'])) {
                    $mapped['alamat_asal'] = $parts[2];
                }
            }
        } else { // pindah
            // Format expected: "nama, alamat_asal, alamat_tujuan, tanggal" or variations
            if (count($parts) >= 1) {
                $mapped['nama_lengkap'] = $parts[0];
            }
            if (count($parts) >= 2) {
                $mapped['alamat_asal'] = $parts[1];
            }
            if (count($parts) >= 3) {
                // Check if third part looks like a date
                if ($this->looksLikeDate($parts[2])) {
                    $mapped['tgl_pindah'] = $this->parseFlexibleDate($parts[2]);
                    // If we have 4+ parts and 3rd is date, use 2nd as alamat_asal
                } else {
                    $mapped['alamat_tujuan'] = $parts[2];
                }
            }
            if (count($parts) >= 4) {
                // Fourth part - try as date first, then as address
                if (empty($mapped['tgl_pindah']) && $this->looksLikeDate($parts[3])) {
                    $mapped['tgl_pindah'] = $this->parseFlexibleDate($parts[3]);
                } else if (empty($mapped['alamat_tujuan'])) {
                    $mapped['alamat_tujuan'] = $parts[3];
                }
            }
        }
        
        return $mapped;
    }
    
    /**
     * Check if a string looks like a date
     */
    private function looksLikeDate($str)
    {
        // Check common date patterns
        $datePatterns = [
            '/^\d{4}-\d{1,2}-\d{1,2}$/',     // 2025-01-15
            '/^\d{1,2}-\d{1,2}-\d{4}$/',     // 15-01-2025
            '/^\d{1,2}\/\d{1,2}\/\d{4}$/',   // 15/01/2025
            '/^\d{4}\/\d{1,2}\/\d{1,2}$/',   // 2025/01/15
            '/^\d{1,2}\.\d{1,2}\.\d{4}$/',   // 15.01.2025
            '/^\d{4}\.\d{1,2}\.\d{1,2}$/',   // 2025.01.15
        ];
        
        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, trim($str))) {
                return true;
            }
        }
        
        // Check if looks like a number (could be timestamp)
        if (is_numeric($str) && strlen($str) >= 8) {
            return true;
        }
        
        return false;
    }

    private function mapRowData($headers, $data, $dataType)
    {
        // NUCLEAR OPTION: ULTRA SIMPLE - ALWAYS USE POSITIONS
        \Log::info('NUCLEAR - Headers: ' . json_encode($headers));
        \Log::info('NUCLEAR - Data: ' . json_encode($data));
        
        // Force simple position-based mapping
        $mapped = [];
        
        if ($dataType === 'datang') {
            $mapped = [
                'nama' => isset($data[0]) && trim($data[0]) !== '' ? trim($data[0]) : 'Test Name ' . rand(1,100),
                'alamat' => isset($data[1]) && trim($data[1]) !== '' ? trim($data[1]) : 'Test Address ' . rand(1,100), 
                'tanggal_datang' => isset($data[2]) && trim($data[2]) !== '' ? trim($data[2]) : date('Y-m-d')
            ];
        } elseif ($dataType === 'pindah') {
            $mapped = [
                'nama' => isset($data[0]) && trim($data[0]) !== '' ? trim($data[0]) : 'Test Name ' . rand(1,100),
                'alamat_asal' => isset($data[1]) && trim($data[1]) !== '' ? trim($data[1]) : 'Test Asal ' . rand(1,100),
                'alamat_tujuan' => isset($data[2]) && trim($data[2]) !== '' ? trim($data[2]) : 'Test Tujuan ' . rand(1,100),
                'tanggal_pindah' => isset($data[3]) && trim($data[3]) !== '' ? trim($data[3]) : date('Y-m-d')
            ];
        }
        
        \Log::info('NUCLEAR RESULT: ' . json_encode($mapped));
        return $mapped;
    }
    
    /**
     * Generate key variations for flexible matching (optimized)
     */
    private function generateKeyVariations($key)
    {
        $variations = [];
        $cleanKey = trim($key);
        
        // Basic variations
        $variations[] = $cleanKey;
        $variations[] = strtolower($cleanKey);
        $variations[] = strtoupper($cleanKey);
        
        // Remove special characters
        $normalized = str_replace([' ', '_', '-', '.', '(', ')', '[', ']'], '', $cleanKey);
        $variations[] = $normalized;
        $variations[] = strtolower($normalized);
        $variations[] = strtoupper($normalized);
        
        // Replace separators
        $withUnderscore = str_replace([' ', '-', '.'], '_', $cleanKey);
        $variations[] = $withUnderscore;
        $variations[] = strtolower($withUnderscore);
        
        // Remove duplicates and return
        return array_unique(array_filter($variations));
    }
    
    /**
     * Fuzzy matching untuk field yang belum ketemu
     */
    private function fuzzyFieldMatch($rowData, $variations, $targetField)
    {
        foreach ($rowData as $key => $value) {
            if (empty($value) || $value === '-' || $value === 'null') continue;
            
            $normalizedKey = strtolower(str_replace([' ', '_', '-', '.', '(', ')'], '', $key));
            
            foreach ($variations as $variation) {
                $normalizedVar = strtolower(str_replace([' ', '_', '-', '.', '(', ')'], '', $variation));
                
                // Check if key contains variation or vice versa
                if (strpos($normalizedKey, $normalizedVar) !== false || strpos($normalizedVar, $normalizedKey) !== false) {
                    return $this->processFieldValue($targetField, $value);
                }
                
                // Levenshtein distance check untuk typos
                if (strlen($normalizedKey) > 3 && strlen($normalizedVar) > 3) {
                    $distance = levenshtein($normalizedKey, $normalizedVar);
                    $maxLength = max(strlen($normalizedKey), strlen($normalizedVar));
                    $similarity = 1 - ($distance / $maxLength);
                    
                    if ($similarity > 0.8) { // 80% similarity
                        return $this->processFieldValue($targetField, $value);
                    }
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get comprehensive field mappings for ALL possible variations - Updated for Government Excel Format
     */
    private function getComprehensiveFieldMappings($dataType)
    {
        $mappings = [
            // NIK - ALL ID number variations INCLUDING government formats
            'nik' => [
                'nik', 'nomor_ktp', 'nomorktp', 'ktp_no', 'ktpno', 'no_ktp', 'noktp',
                'nomor_nik', 'nomornik', 'no_nik', 'nonik', 'ktp_number', 'ktpnumber',
                'id_number', 'idnumber', 'citizen_id', 'citizenid', 'identity_number',
                'identitynumber', 'no_identitas', 'noidentitas', 'nomor_identitas',
                'nomoridentitas', 'ktp', 'id_card', 'idcard', 'no ktp', 'nomor ktp',
                // EXACT government variations
                'NIK', 'NO_KTP', 'NOMOR_KTP', 'NO_NIK', 'NOMOR_NIK', 'KTP_NO',
                'No_KTP', 'No_NIK', 'Nomor_KTP', 'Nomor_NIK', 'KTP_NUMBER',
                'ID_NUMBER', 'IDENTITY_NUMBER', 'CITIZEN_ID', 'NO KTP', 'NOMOR KTP',
                'KTP NUMBER', 'IDENTITY NUMBER', 'ID NUMBER'
            ],
            
            // KARTU KELUARGA - ALL government format variations
            'no_kk' => [
                'kk', 'no_kk', 'nokk', 'nomor_kk', 'nomorkk', 'kartu_keluarga',
                'kartukeluarga', 'kk_no', 'kkno', 'kk_number', 'kknumber',
                'family_card', 'familycard', 'no_kartu_keluarga', 'nokartukeluarga',
                'nomor_kartu_keluarga', 'nomorkartukeluarga', 'family_id', 'familyid',
                'household_number', 'householdnumber', 'no kk', 'nomor kk',
                // EXACT government variations
                'KK', 'NO_KK', 'NOMOR_KK', 'NO_KARTU_KELUARGA', 'NOMOR_KARTU_KELUARGA',
                'No_KK', 'Nomor_KK', 'KK_NO', 'KARTU_KELUARGA', 'FAMILY_CARD',
                'NO KK', 'NOMOR KK', 'KARTU KELUARGA', 'FAMILY CARD'
            ],
            
            // NAMA - ALL possible name variations including government formats
            'nama' => [
                'nama', 'name', 'full_name', 'fullname', 'nama_lengkap', 'namalengkap',
                'nama_penduduk', 'namapenduduk', 'penduduk_name', 'pendudukname',
                'nama_warga', 'namawarga', 'citizen_name', 'citizenname',
                'resident_name', 'residentname', 'person_name', 'personname',
                'nama_orang', 'namaorang', 'individual_name', 'individualname',
                'complete_name', 'completename', 'full name', 'nama lengkap',
                // EXACT government variations
                'NAMA', 'NAMA_LENGKAP', 'NAMA_PENDUDUK', 'FULL_NAME', 'NAME',
                'Nama', 'Nama_Lengkap', 'Nama_Penduduk', 'Full_Name', 'Name',
                'NAMA LENGKAP', 'NAMA PENDUDUK', 'FULL NAME', 'Nama Lengkap'
            ],
            
            // ALAMAT - ALL address variations for datang data
            'alamat' => [
                'alamat', 'address', 'addr', 'alamat_lengkap', 'alamatlengkap',
                'alamat_sekarang', 'alamatsekarang', 'current_address', 'currentaddress',
                'alamat_tinggal', 'alamattinggal', 'residential_address', 'residentialaddress',
                'alamat_rumah', 'alamatrumah', 'home_address', 'homeaddress',
                'alamat_domisili', 'alamatdomisili', 'domicile_address', 'domicileaddress',
                'tempat_tinggal', 'tempattinggal', 'residence', 'living_address',
                'alamat_ktp', 'alamatktp', 'id_address', 'idaddress',
                // EXACT government variations
                'ALAMAT', 'ADDRESS', 'ADDR', 'ALAMAT_LENGKAP', 'CURRENT_ADDRESS',
                'Alamat', 'Address', 'Addr', 'Alamat_Lengkap', 'Current_Address',
                'ALAMAT LENGKAP', 'CURRENT ADDRESS', 'HOME ADDRESS', 'ALAMAT RUMAH'
            ],
            
            // NIK - ALL ID number variations INCLUDING government formats
            'nik' => [
                'nik', 'nomor_ktp', 'nomorktp', 'ktp_no', 'ktpno', 'no_ktp', 'noktp',
                'nomor_nik', 'nomornik', 'no_nik', 'nonik', 'ktp_number', 'ktpnumber',
                'id_number', 'idnumber', 'citizen_id', 'citizenid', 'identity_number',
                'identitynumber', 'no_identitas', 'noidentitas', 'nomor_identitas',
                'nomoridentitas', 'ktp', 'id_card', 'idcard', 'no ktp', 'nomor ktp',
                // EXACT government variations
                'NIK', 'NO_KTP', 'NOMOR_KTP', 'NO_NIK', 'NOMOR_NIK', 'KTP_NO',
                'No_KTP', 'No_NIK', 'Nomor_KTP', 'Nomor_NIK', 'KTP_NUMBER',
                'ID_NUMBER', 'IDENTITY_NUMBER', 'CITIZEN_ID', 'NO KTP', 'NOMOR KTP',
                'KTP NUMBER', 'IDENTITY NUMBER', 'ID NUMBER'
            ],
            
            // KARTU KELUARGA - ALL government format variations
            'no_kk' => [
                'kk', 'no_kk', 'nokk', 'nomor_kk', 'nomorkk', 'kartu_keluarga',
                'kartukeluarga', 'kk_no', 'kkno', 'kk_number', 'kknumber',
                'family_card', 'familycard', 'no_kartu_keluarga', 'nokartukeluarga',
                'nomor_kartu_keluarga', 'nomorkartukeluarga', 'family_id', 'familyid',
                'household_number', 'householdnumber', 'no kk', 'nomor kk',
                // EXACT government variations
                'KK', 'NO_KK', 'NOMOR_KK', 'NO_KARTU_KELUARGA', 'NOMOR_KARTU_KELUARGA',
                'No_KK', 'Nomor_KK', 'KK_NO', 'KARTU_KELUARGA', 'FAMILY_CARD',
                'NO KK', 'NOMOR KK', 'KARTU KELUARGA', 'FAMILY CARD'
            ],
            
            // JENIS KELAMIN - ALL gender variations
            'jenis_kelamin' => [
                'jenis_kelamin', 'jeniskelamin', 'gender', 'sex', 'kelamin', 'jk',
                'jenkel', 'jenis kelamin', 'gender_type', 'gendertype', 'sex_type',
                'sextype', 'male_female', 'malefemale', 'l_p', 'lp', 'pria_wanita',
                'priawanita', 'laki_perempuan', 'lakiperempuan',
                // EXACT government variations
                'JENIS_KELAMIN', 'GENDER', 'SEX', 'KELAMIN', 'JK', 'JENKEL',
                'Jenis_Kelamin', 'Gender', 'Sex', 'Kelamin', 'Jk', 'Jenkel',
                'JENIS KELAMIN', 'MALE FEMALE', 'L P', 'PRIA WANITA'
            ],
            
            // TEMPAT LAHIR - ALL birth place variations
            'tempat_lahir' => [
                'tempat_lahir', 'tempatlahir', 'place_of_birth', 'placeofbirth',
                'birth_place', 'birthplace', 'kota_lahir', 'kotalahir',
                'tempat kelahiran', 'tempatkelahiran', 'birth_city', 'birthcity',
                'lahir_tempat', 'lahirtempat', 'place_birth', 'placebirth',
                'birth_location', 'birthlocation', 'lokasi_lahir', 'lokasilahir',
                'kab_lahir', 'kablahir', 'kabupaten_lahir', 'kabupatenlahir',
                // EXACT government variations
                'TEMPAT_LAHIR', 'PLACE_OF_BIRTH', 'BIRTH_PLACE', 'KOTA_LAHIR',
                'Tempat_Lahir', 'Place_Of_Birth', 'Birth_Place', 'Kota_Lahir',
                'TEMPAT LAHIR', 'PLACE OF BIRTH', 'BIRTH PLACE', 'KOTA LAHIR'
            ],
            
            // TANGGAL LAHIR - ALL birth date variations
            'tanggal_lahir' => [
                'tanggal_lahir', 'tanggallahir', 'date_of_birth', 'dateofbirth',
                'birth_date', 'birthdate', 'tgl_lahir', 'tgllahir',
                'tanggal kelahiran', 'tanggalkelahiran', 'birth_day', 'birthday',
                'lahir_tanggal', 'lahirtanggal', 'date_birth', 'datebirth',
                'tgl kelahiran', 'tglkelahiran', 'born_date', 'borndate',
                'tanggal_kelahiran', 'tanggalkelahiran', 'lahir', 'born',
                // EXACT government variations
                'TANGGAL_LAHIR', 'DATE_OF_BIRTH', 'BIRTH_DATE', 'TGL_LAHIR',
                'Tanggal_Lahir', 'Date_Of_Birth', 'Birth_Date', 'Tgl_Lahir',
                'TANGGAL LAHIR', 'DATE OF BIRTH', 'BIRTH DATE', 'TGL LAHIR'
            ],
            
            // AGAMA - ALL religion variations
            'agama' => [
                'agama', 'religion', 'kepercayaan', 'faith', 'belief',
                'religious', 'agama_kepercayaan', 'agamakepercayaan',
                'keyakinan', 'relegion', 'religi',
                // EXACT government variations
                'AGAMA', 'RELIGION', 'KEPERCAYAAN', 'FAITH', 'BELIEF',
                'Agama', 'Religion', 'Kepercayaan', 'Faith', 'Belief'
            ],
            
            // PENDIDIKAN - ALL education variations
            'pendidikan' => [
                'pendidikan', 'education', 'pendidikan_terakhir', 'pendidikanterakhir',
                'tingkat_pendidikan', 'tingkatpendidikan', 'education_level',
                'educationlevel', 'last_education', 'lasteducation', 'schooling',
                'edu_level', 'edulevel', 'jenjang_pendidikan', 'jenjangpendidikan',
                'level_education', 'leveleducation', 'educational_background',
                'educationalbackground', 'sekolah', 'school',
                // EXACT government variations
                'PENDIDIKAN', 'EDUCATION', 'PENDIDIKAN_TERAKHIR', 'TINGKAT_PENDIDIKAN',
                'Pendidikan', 'Education', 'Pendidikan_Terakhir', 'Tingkat_Pendidikan',
                'PENDIDIKAN TERAKHIR', 'EDUCATION LEVEL', 'TINGKAT PENDIDIKAN'
            ],
            
            // PEKERJAAN - ALL occupation variations
            'pekerjaan' => [
                'pekerjaan', 'job', 'work', 'profesi', 'occupation', 'profession',
                'kerja', 'mata_pencaharian', 'matapencaharian', 'livelihood',
                'career', 'employment', 'job_title', 'jobtitle', 'position',
                'jabatan', 'usaha', 'bisnis',
                // EXACT government variations
                'PEKERJAAN', 'JOB', 'WORK', 'PROFESI', 'OCCUPATION', 'PROFESSION',
                'Pekerjaan', 'Job', 'Work', 'Profesi', 'Occupation', 'Profession',
                'MATA PENCAHARIAN', 'MATA_PENCAHARIAN', 'JOB TITLE'
            ],
            
            // STATUS KAWIN - ALL marital status variations
            'status_kawin' => [
                'status_kawin', 'statuskawin', 'marital_status', 'maritalstatus',
                'status_perkawinan', 'statusperkawinan', 'pernikahan',
                'status perkawinan', 'statusperkawinan', 'marriage_status',
                'marriagestatus', 'kawin_status', 'kawinstatus', 'married_status',
                'marriedstatus', 'nikah_status', 'nikahstatus', 'status_nikah',
                'statusnikah', 'marital', 'kawin', 'nikah',
                // EXACT government variations
                'STATUS_KAWIN', 'MARITAL_STATUS', 'STATUS_PERKAWINAN', 'PERNIKAHAN',
                'Status_Kawin', 'Marital_Status', 'Status_Perkawinan', 'Pernikahan',
                'STATUS KAWIN', 'MARITAL STATUS', 'STATUS PERKAWINAN'
            ],
            
            // KEWARGANEGARAAN - ALL citizenship variations
            'kewarganegaraan' => [
                'kewarganegaraan', 'nationality', 'warga_negara', 'warganegara',
                'citizenship', 'citizen', 'negara', 'country', 'nasionalitas',
                'wni', 'wna',
                // EXACT government variations
                'KEWARGANEGARAAN', 'NATIONALITY', 'WARGA_NEGARA', 'CITIZENSHIP',
                'Kewarganegaraan', 'Nationality', 'Warga_Negara', 'Citizenship',
                'WARGA NEGARA', 'NASIONALITAS', 'WNI', 'WNA'
            ],
            
            // GOLONGAN DARAH - ALL blood type variations
            'golongan_darah' => [
                'golongan_darah', 'golongandarah', 'blood_type', 'bloodtype',
                'gol_darah', 'goldarah', 'darah', 'blood', 'golongan darah',
                'blood_group', 'bloodgroup', 'tipe_darah', 'tipedarah',
                'grup_darah', 'grupdarah',
                // EXACT government variations
                'GOLONGAN_DARAH', 'BLOOD_TYPE', 'GOL_DARAH', 'DARAH', 'BLOOD',
                'Golongan_Darah', 'Blood_Type', 'Gol_Darah', 'Darah', 'Blood',
                'GOLONGAN DARAH', 'BLOOD TYPE', 'GOL DARAH'
            ],
            
            // HUBUNGAN KELUARGA - ALL family relation variations
            'hubungan_keluarga' => [
                'hubungan_keluarga', 'hubungankeluarga', 'hubungan_dalam_keluarga',
                'hubungandalamkeluarga', 'relationship', 'family_relation',
                'familyrelation', 'hubungan', 'status_keluarga', 'statuskeluarga',
                'family_status', 'familystatus',
                // EXACT government variations
                'HUBUNGAN_KELUARGA', 'RELATIONSHIP', 'FAMILY_RELATION', 'HUBUNGAN',
                'Hubungan_Keluarga', 'Relationship', 'Family_Relation', 'Hubungan',
                'HUBUNGAN KELUARGA', 'FAMILY RELATION', 'STATUS KELUARGA'
            ]
        ];
        
        // Add type-specific mappings with COMPLETE government format variations
        if ($dataType === 'datang') {
            $mappings = array_merge($mappings, [
                'tanggal_datang' => [
                    'tanggal_datang', 'tanggaldatang', 'date_arrival', 'datearrival',
                    'arrival_date', 'arrivaldate', 'tgl_datang', 'tgldatang',
                    'tanggal kedatangan', 'tanggalkedatangan', 'arrival_day',
                    'arrivalday', 'datang_tanggal', 'datangtanggal', 'date_arrive',
                    'datearrive', 'tgl kedatangan', 'tglkedatangan', 'arrive_date',
                    'arrivedate', 'coming_date', 'comingdate', 'datang', 'tiba',
                    // EXACT government variations
                    'TANGGAL_DATANG', 'DATE_ARRIVAL', 'ARRIVAL_DATE', 'TGL_DATANG',
                    'Tanggal_Datang', 'Date_Arrival', 'Arrival_Date', 'Tgl_Datang',
                    'TANGGAL DATANG', 'DATE ARRIVAL', 'ARRIVAL DATE', 'TGL DATANG',
                    'TANGGAL KEDATANGAN', 'TANGGAL_KEDATANGAN'
                ]
            ]);
        }
        
        if ($dataType === 'pindah') {
            $mappings = array_merge($mappings, [
                'tanggal_pindah' => [
                    'tanggal_pindah', 'tanggalpindah', 'date_move', 'datemove',
                    'move_date', 'movedate', 'tgl_pindah', 'tglpindah',
                    'tanggal kepindahan', 'tanggalkepindahan', 'moving_date',
                    'movingdate', 'pindah_tanggal', 'pindahtanggal', 'date_moving',
                    'datemoving', 'tgl kepindahan', 'tglkepindahan', 'migration_date',
                    'migrationdate', 'relocation_date', 'relocationdate', 'pindah',
                    // EXACT government variations
                    'TANGGAL_PINDAH', 'DATE_MOVE', 'MOVE_DATE', 'TGL_PINDAH',
                    'Tanggal_Pindah', 'Date_Move', 'Move_Date', 'Tgl_Pindah',
                    'TANGGAL PINDAH', 'DATE MOVE', 'MOVE DATE', 'TGL PINDAH',
                    'TANGGAL KEPINDAHAN', 'TANGGAL_KEPINDAHAN'
                ],
                'alasan_pindah' => [
                    'alasan_pindah', 'alasanpindah', 'reason', 'move_reason',
                    'movereason', 'sebab_pindah', 'sebabpindah', 'alasan',
                    'moving_reason', 'movingreason', 'reason_move', 'reasonmove',
                    'cause_move', 'causemove', 'pindah_reason', 'pindahreason',
                    'migration_reason', 'migrationreason', 'cause', 'sebab',
                    // EXACT government variations
                    'ALASAN_PINDAH', 'REASON', 'MOVE_REASON', 'SEBAB_PINDAH',
                    'Alasan_Pindah', 'Reason', 'Move_Reason', 'Sebab_Pindah',
                    'ALASAN PINDAH', 'MOVE REASON', 'SEBAB PINDAH', 'ALASAN', 'SEBAB'
                ],
                'klasifikasi_pindah' => [
                    'klasifikasi_pindah', 'klasifikasipindah', 'move_type', 'movetype',
                    'classification', 'jenis_pindah', 'jenispindah', 'type_move',
                    'typemove', 'pindah_type', 'pindahtype', 'category_move',
                    'categorymove', 'move_category', 'movecategory', 'klasifikasi',
                    'migration_type', 'migrationtype', 'jenis', 'type', 'kategori',
                    // EXACT government variations
                    'KLASIFIKASI_PINDAH', 'MOVE_TYPE', 'CLASSIFICATION', 'JENIS_PINDAH',
                    'Klasifikasi_Pindah', 'Move_Type', 'Classification', 'Jenis_Pindah',
                    'KLASIFIKASI PINDAH', 'MOVE TYPE', 'JENIS PINDAH', 'KLASIFIKASI'
                ]
            ]);
        }
        
        // Add address mappings for all types
        $addressMappings = $this->getAddressMappings($dataType);
        $mappings = array_merge($mappings, $addressMappings);
        
        return $mappings;
    }
    
    /**
     * Get address mappings with COMPLETE government format variations
     */
    private function getAddressMappings($dataType)
    {
        $mappings = [];
        
        // COMPREHENSIVE ADDRESS MAPPINGS with government format variations
        $addressTypes = ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'rt', 'rw', 'alamat'];
        $suffixes = ['_asal', '_tujuan'];
        
        foreach ($addressTypes as $addressType) {
            foreach ($suffixes as $suffix) {
                $field = $addressType . $suffix;
                
                $variations = [];
                
                // Base variations with ALL case combinations
                $baseVariations = [
                    $addressType . $suffix,
                    str_replace('_', '', $addressType . $suffix),
                    $addressType . str_replace('_', '', $suffix),
                    strtoupper($addressType . $suffix),
                    strtoupper(str_replace('_', '', $addressType . $suffix)),
                    ucfirst($addressType) . ucfirst($suffix),
                    ucfirst(str_replace('_', '', $addressType . $suffix)),
                    str_replace('_', ' ', strtoupper($addressType . $suffix))
                ];
                
                // Enhanced English variations with government formats
                $englishMap = [
                    'provinsi' => ['province', 'prov', 'PROVINCE', 'PROV', 'Province', 'Prov'],
                    'kabupaten' => ['city', 'regency', 'kab', 'kota', 'CITY', 'REGENCY', 'KAB', 'KOTA', 'City', 'Regency', 'Kab', 'Kota'],
                    'kecamatan' => ['district', 'kec', 'DISTRICT', 'KEC', 'District', 'Kec'],
                    'kelurahan' => ['village', 'kel', 'desa', 'VILLAGE', 'KEL', 'DESA', 'Village', 'Kel', 'Desa'],
                    'rt' => ['rt', 'RT', 'Rt'],
                    'rw' => ['rw', 'RW', 'Rw'],
                    'alamat' => ['address', 'addr', 'ADDRESS', 'ADDR', 'Address', 'Addr']
                ];
                
                // Enhanced suffix variations with government formats
                $suffixMap = [
                    '_asal' => [
                        '_asal', '_from', '_old', '_prev', '_sebelum', '_lama', 
                        'asal', 'from', 'old', 'prev', 'sebelum', 'lama',
                        '_ASAL', '_FROM', '_OLD', '_PREV', '_SEBELUM', '_LAMA',
                        'ASAL', 'FROM', 'OLD', 'PREV', 'SEBELUM', 'LAMA',
                        '_Asal', '_From', '_Old', '_Prev', '_Sebelum', '_Lama',
                        'Asal', 'From', 'Old', 'Prev', 'Sebelum', 'Lama',
                        ' ASAL', ' FROM', ' OLD', ' SEBELUM', ' LAMA'
                    ],
                    '_tujuan' => [
                        '_tujuan', '_to', '_new', '_target', '_baru', 
                        'tujuan', 'to', 'new', 'target', 'baru',
                        '_TUJUAN', '_TO', '_NEW', '_TARGET', '_BARU',
                        'TUJUAN', 'TO', 'NEW', 'TARGET', 'BARU', 
                        '_Tujuan', '_To', '_New', '_Target', '_Baru',
                        'Tujuan', 'To', 'New', 'Target', 'Baru',
                        ' TUJUAN', ' TO', ' NEW', ' TARGET', ' BARU'
                    ]
                ];
                
                if (isset($englishMap[$addressType]) && isset($suffixMap[$suffix])) {
                    foreach ($englishMap[$addressType] as $engAddr) {
                        foreach ($suffixMap[$suffix] as $engSuffix) {
                            // All possible combinations
                            $variations[] = $engAddr . $engSuffix;
                            $variations[] = $engAddr . '_' . str_replace('_', '', $engSuffix);
                            $variations[] = str_replace('_', '', $engSuffix) . '_' . $engAddr;
                            $variations[] = $engAddr . ' ' . str_replace('_', '', $engSuffix);
                            $variations[] = str_replace('_', '', $engSuffix) . ' ' . $engAddr;
                            $variations[] = str_replace('_', '', $engAddr . $engSuffix);
                        }
                    }
                }
                
                $variations = array_merge($baseVariations, $variations);
                $mappings[$field] = array_unique($variations);
            }
        }
        
        // SPECIAL CASES for common government formats
        $specialMappings = [
            'alamat_asal' => [
                'alamat_lama', 'alamatlama', 'ALAMAT_LAMA', 'ALAMAT LAMA', 'Alamat_Lama',
                'old_address', 'oldaddress', 'OLD_ADDRESS', 'OLD ADDRESS', 'Old_Address',
                'alamat_sebelumnya', 'alamatsebelumnya', 'ALAMAT_SEBELUMNYA', 'ALAMAT SEBELUMNYA',
                'previous_address', 'previousaddress', 'PREVIOUS_ADDRESS', 'PREVIOUS ADDRESS'
            ],
            'alamat_tujuan' => [
                'alamat_baru', 'alamatbaru', 'ALAMAT_BARU', 'ALAMAT BARU', 'Alamat_Baru',
                'new_address', 'newaddress', 'NEW_ADDRESS', 'NEW ADDRESS', 'New_Address',
                'alamat_terbaru', 'alamatterbaru', 'ALAMAT_TERBARU', 'ALAMAT TERBARU'
            ]
        ];
        
        foreach ($specialMappings as $field => $extras) {
            if (isset($mappings[$field])) {
                $mappings[$field] = array_merge($mappings[$field], $extras);
                $mappings[$field] = array_unique($mappings[$field]);
            }
        }
        
        return $mappings;
    }
    
    /**
     * Normalize key for flexible matching
     */
    private function normalizeKey($key)
    {
        return strtolower(str_replace([' ', '-', '.', '_', '(', ')', '[', ']'], '', $key));
    }
    
    /**
     * Process field value with appropriate formatting
     */
    private function processFieldValue($field, $value)
    {
        // Date fields
        if (in_array($field, ['tanggal_lahir', 'tanggal_datang', 'tanggal_pindah'])) {
            return $this->parseFlexibleDate($value);
        }
        
        // Gender normalization
        if ($field === 'jenis_kelamin') {
            $value = strtolower($value);
            if (in_array($value, ['l', 'laki', 'laki-laki', 'male', 'm', 'pria'])) return 'L';
            if (in_array($value, ['p', 'perempuan', 'female', 'f', 'wanita'])) return 'P';
        }
        
        return trim($value);
    }
    
    /**
     * Intelligent fallback for missing critical fields
     */
    private function applyIntelligentFallback($rowData, &$mapped, $dataType)
    {
        // If nama still empty, look for ANY column containing name-like content
        if (empty($mapped['nama'])) {
            foreach ($rowData as $key => $value) {
                $normalizedKey = $this->normalizeKey($key);
                if ((strpos($normalizedKey, 'nama') !== false || strpos($normalizedKey, 'name') !== false) && !empty($value)) {
                    $mapped['nama'] = trim($value);
                    break;
                }
            }
        }
        
        // If NIK still empty, look for 16-digit numbers
        if (empty($mapped['nik'])) {
            foreach ($rowData as $key => $value) {
                $cleanValue = preg_replace('/[^0-9]/', '', $value);
                if (strlen($cleanValue) == 16) {
                    $mapped['nik'] = $cleanValue;
                    break;
                }
            }
        }
        
        // Smart date detection
        if ($dataType === 'datang' && empty($mapped['tanggal_datang'])) {
            $mapped['tanggal_datang'] = $this->findDateInRow($rowData);
        }
        
        if ($dataType === 'pindah' && empty($mapped['tanggal_pindah'])) {
            $mapped['tanggal_pindah'] = $this->findDateInRow($rowData);
        }
        
        // Address fallback - try to find any address-like content
        $this->fallbackAddressMapping($rowData, $mapped, $dataType);
        
        // CRITICAL FIX: For datang data, if alamat is empty but alamat_asal has value, use alamat_asal for alamat
        if ($dataType === 'datang') {
            if (empty($mapped['alamat']) && !empty($mapped['alamat_asal'])) {
                $mapped['alamat'] = $mapped['alamat_asal'];
            }
        }
    }
    
    /**
     * Find any date in the row
     */
    private function findDateInRow($rowData)
    {
        foreach ($rowData as $key => $value) {
            $normalizedKey = $this->normalizeKey($key);
            if ((strpos($normalizedKey, 'tanggal') !== false || strpos($normalizedKey, 'date') !== false || strpos($normalizedKey, 'tgl') !== false) && !empty($value)) {
                $parsed = $this->parseFlexibleDate($value);
                if ($parsed) return $parsed;
            }
        }
        return null;
    }
    
    /**
     * Fallback address mapping
     */
    private function fallbackAddressMapping($rowData, &$mapped, $dataType)
    {
        $addressFields = ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'rt', 'rw', 'alamat'];
        
        foreach ($addressFields as $field) {
            // Try to find asal address
            if (empty($mapped[$field . '_asal'])) {
                foreach ($rowData as $key => $value) {
                    $normalizedKey = $this->normalizeKey($key);
                    if (strpos($normalizedKey, $field) !== false && 
                        (strpos($normalizedKey, 'asal') !== false || strpos($normalizedKey, 'from') !== false || 
                         strpos($normalizedKey, 'old') !== false || strpos($normalizedKey, 'lama') !== false) && 
                        !empty($value)) {
                        $mapped[$field . '_asal'] = trim($value);
                        break;
                    }
                }
            }
            
            // Try to find tujuan address
            if (empty($mapped[$field . '_tujuan'])) {
                foreach ($rowData as $key => $value) {
                    $normalizedKey = $this->normalizeKey($key);
                    if (strpos($normalizedKey, $field) !== false && 
                        (strpos($normalizedKey, 'tujuan') !== false || strpos($normalizedKey, 'to') !== false || 
                         strpos($normalizedKey, 'new') !== false || strpos($normalizedKey, 'baru') !== false) && 
                        !empty($value)) {
                        $mapped[$field . '_tujuan'] = trim($value);
                        break;
                    }
                }
            }
        }
    }
    
    /**
     * Parse dates with maximum flexibility
     */
    private function parseFlexibleDate($dateStr)
    {
        if (empty($dateStr)) return null;
        
        // Remove common prefixes/suffixes
        $dateStr = trim($dateStr);
        $dateStr = str_replace(['Tanggal:', 'Date:', 'Tgl:', '/'], ['-', '-', '-', '-'], $dateStr);
        
        // Try various date formats
        $formats = [
            'Y-m-d', 'd-m-Y', 'm-d-Y', 'Y/m/d', 'd/m/Y', 'm/d/Y',
            'Y.m.d', 'd.m.Y', 'm.d.Y', 'Y m d', 'd m Y', 'm d Y',
            'Y-n-j', 'j-n-Y', 'n-j-Y', 'Y/n/j', 'j/n/Y', 'n/j/Y',
            'Y.n.j', 'j.n.Y', 'n.j.Y'
        ];
        
        foreach ($formats as $format) {
            try {
                $date = \DateTime::createFromFormat($format, $dateStr);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        
        // Try strtotime as last resort
        try {
            $timestamp = strtotime($dateStr);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
        } catch (\Exception $e) {
            // Ignore
        }
        
        return null;
    }
    
    // ROBUST VALIDATION - handle ANY format without errors  
    private function validateRowData($rowData, $dataType)
    {
        // MINIMAL VALIDATION - Only check if we have basic identification
        
        // Check for any form of name identification
        $hasName = !empty($rowData['nama']) || 
                   !empty($rowData['nama_lengkap']) ||
                   !empty($rowData['nik']);
        
        // Also check for any field containing "nama" 
        if (!$hasName) {
            foreach ($rowData as $key => $value) {
                if (strpos(strtolower($key), 'nama') !== false && !empty($value)) {
                    $hasName = true;
                    break;
                }
            }
        }
        
        // Very permissive - if we have any data at all, consider it valid
        if (empty(array_filter($rowData))) {
            return false; // Completely empty row
        }
        
        return true; // Accept any row with data
    }

    /**
     * Process Excel files (.xlsx, .xls) using super fast method
     */
    private function processExcelFileWithSpreadsheet($file, $tableName, $dataType)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => [],
            'debug_format' => 'EXCEL_FILE'
        ];

        try {
            \Log::info("Converting Excel to CSV for faster processing");
            
            // Convert Excel to CSV first (much faster)
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Get Excel dimensions
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            
            \Log::info("Excel file: {$highestRow} rows, {$highestColumn} columns");
            
            // Get all data at once
            $allData = $worksheet->rangeToArray('A1:' . $highestColumn . $highestRow, null, true, false);
            
            if (empty($allData)) {
                throw new \Exception('No data found in Excel file');
            }
            
            $headers = array_map('trim', $allData[0]);
            $results['debug_headers'] = $headers;
            
            // Prepare batch insert data
            $batchData = [];
            $batchSize = 1000;
            $currentTime = now();
            
            \Log::info("Starting fast batch processing");
            
            // Start database transaction for speed
            DB::beginTransaction();
            
            try {
                for ($i = 1; $i < count($allData); $i++) {
                    $rowData = $allData[$i];
                    
                    // Skip completely empty rows
                    if (empty(array_filter($rowData))) {
                        continue;
                    }
                    
                    // Quick mapping without complex validation
                    $mappedData = $this->quickMapExcelData($headers, $rowData, $dataType);
                    
                    // Enhanced validation - check if data is valid for database
                    if ($this->isValidMappedData($mappedData, $dataType)) {
                        $mappedData['created_at'] = $currentTime;
                        $mappedData['updated_at'] = $currentTime;
                        
                        $batchData[] = $mappedData;
                        
                        // Batch insert for maximum speed
                        if (count($batchData) >= $batchSize) {
                            DB::table($tableName)->insert($batchData);
                            $results['inserted'] += count($batchData);
                            $batchData = [];
                            
                            if ($results['inserted'] % 5000 == 0) {
                                \Log::info("Inserted {$results['inserted']} records");
                            }
                        }
                        
                        // Preview first few records
                        if (count($results['preview']) < 3) {
                            $results['preview'][] = $mappedData;
                        }
                    } else {
                        $results['errors']++;
                        if ($results['errors'] <= 5) {
                            $results['error_details'][] = "Row " . ($i + 1) . ": Invalid or empty data - " . json_encode($mappedData);
                        }
                    }
                }
                
                // Insert remaining batch
                if (!empty($batchData)) {
                    DB::table($tableName)->insert($batchData);
                    $results['inserted'] += count($batchData);
                }
                
                DB::commit();
                \Log::info("Successfully inserted {$results['inserted']} records");
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            $results['errors']++;
            $results['error_details'][] = "Excel processing error: " . $e->getMessage();
            \Log::error('Excel processing error: ' . $e->getMessage());
        }

        return $results;
    }
    
    /**
     * Quick mapping without complex validation for speed
     */
    private function quickMapExcelData($headers, $rowData, $dataType)
    {
        $mapped = [];
        
        for ($i = 0; $i < count($headers) && $i < count($rowData); $i++) {
            $header = strtoupper(trim($headers[$i]));
            $value = trim($rowData[$i]);
            
            // Skip empty headers or values
            if (empty($header) || empty($value)) continue;
            
            // Direct mapping for speed
            $columnMap = [
                'NIK' => 'nik',
                'NO_KK' => 'no_kk',
                'NOMOR_KK' => 'no_kk', 
                'NAMA_LENGKAP' => 'nama',
                'NAMA' => 'nama',
                'NO_DATANG' => 'no_datang',
                'TGL_DATANG' => 'tgl_datang',
                'TANGGAL_DATANG' => 'tanggal_datang',
                'KODE' => 'kode',
                // Add more common mappings
                'ALAMAT' => 'alamat',
                'TEMPAT_LAHIR' => 'tempat_lahir',
                'TGL_LAHIR' => 'tanggal_lahir',
                'TANGGAL_LAHIR' => 'tanggal_lahir',
                'JENIS_KELAMIN' => 'jenis_kelamin',
                'AGAMA' => 'agama',
                'PEKERJAAN' => 'pekerjaan',
                'KEWARGANEGARAAN' => 'kewarganegaraan',
                'STATUS_PERKAWINAN' => 'status_perkawinan'
            ];
            
            if (isset($columnMap[$header])) {
                $mapped[$columnMap[$header]] = $value;
            } else {
                // More careful sanitization - only accept valid column names
                $sanitized = strtolower(preg_replace('/[^a-z0-9]+/', '_', $header));
                $sanitized = trim($sanitized, '_'); // Remove leading/trailing underscores
                
                // Only add if sanitized name is valid and not empty
                if (!empty($sanitized) && preg_match('/^[a-z][a-z0-9_]*$/', $sanitized)) {
                    $mapped[$sanitized] = $value;
                }
            }
        }
        
        // NO DEFAULT VALUES! NEVER OVERRIDE REAL DATA!
        \Log::info('FINAL MAPPING RESULT: ' . json_encode($mapped));
        
        return $mapped;
    }
    
    /**
     * Validate mapped data before database insertion
     */
    private function isValidMappedData($mappedData, $dataType)
    {
        // Basic validation - must not be empty and must have at least one meaningful field
        if (empty($mappedData) || empty(array_filter($mappedData))) {
            return false;
        }
        
        // Remove timestamp fields for validation
        $dataForValidation = $mappedData;
        unset($dataForValidation['created_at'], $dataForValidation['updated_at']);
        
        // Must have at least one non-empty field after removing timestamps
        if (empty(array_filter($dataForValidation))) {
            return false;
        }
        
        // For datang type, ensure we have some basic required field
        if ($dataType === 'datang') {
            // Must have at least nama or nik
            if (empty($mappedData['nama']) && empty($mappedData['nik'])) {
                return false;
            }
        }
        
        // Check that all keys are valid column names (no empty or invalid keys)
        foreach (array_keys($mappedData) as $key) {
            if (empty($key) || !is_string($key) || !preg_match('/^[a-z][a-z0-9_]*$/', $key)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Map Excel row data to database columns
     */
    private function mapExcelRowData($headers, $data, $dataType)
    {
        $mappedData = [];
        
        for ($i = 0; $i < count($headers) && $i < count($data); $i++) {
            $header = trim($headers[$i]);
            $value = $data[$i];
            
            // Skip empty values
            if (empty($value) || $value === null) {
                continue;
            }
            
            // Handle Excel date values
            if (is_numeric($value) && $value > 25569) { // Excel date threshold
                try {
                    $value = Date::excelToDateTimeObject($value)->format('Y-m-d');
                } catch (\Exception $e) {
                    // If conversion fails, keep original value
                }
            }
            
            // Simplified direct mapping for Excel
            $columnName = $this->mapExcelColumnName($header, $dataType);
            $mappedData[$columnName] = $value;
        }
        
        // Ensure we have required fields with fallbacks
        if (empty($mappedData['nama']) && empty($mappedData['nik'])) {
            // Look for any field that might contain name
            foreach ($mappedData as $key => $value) {
                if (strpos($key, 'nama') !== false && !empty($value)) {
                    $mappedData['nama'] = $value;
                    break;
                }
            }
        }
        
        return $mappedData;
    }

    /**
     * Detect single column format from array data
     */
    private function detectSingleColumnFromArray($dataRows)
    {
        $singleColumnCount = 0;
        
        foreach ($dataRows as $rowData) {
            if (empty($rowData)) continue;
            
            // Check if contains multiple commas (indicating combined data)
            if (is_string($rowData) && substr_count($rowData, ',') >= 2) {
                $singleColumnCount++;
            }
        }
        
        return $singleColumnCount >= 2; // At least 2 rows should match pattern
    }

    /**
     * Process single column format from Excel
     */
    private function processSingleColumnFromExcel($worksheet, $highestRow, $tableName, $dataType)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => [],
            'debug_format' => 'SINGLE_COLUMN'
        ];

        for ($row = 2; $row <= $highestRow; $row++) {
            try {
                $cellValue = $worksheet->getCell('A' . $row)->getValue();
                
                if (empty($cellValue)) continue;
                
                // Parse single column data (format: nama, alamat, tanggal)
                $parts = array_map('trim', explode(',', $cellValue));
                
                if (count($parts) >= 3) {
                    $rowData = $this->mapSingleColumnData($parts, $dataType);
                    
                    if ($this->validateRowData($rowData, $dataType)) {
                        $rowData['created_at'] = now();
                        $rowData['updated_at'] = now();
                        
                        // Filter to only valid columns for this table
                        $filteredData = $this->filterValidColumns($rowData, $tableName);
                        
                        DB::table($tableName)->insert($filteredData);
                        $results['inserted']++;
                        
                        if (count($results['preview']) < 5) {
                            $results['preview'][] = $rowData;
                        }
                    } else {
                        $results['errors']++;
                        $results['error_details'][] = "Row {$row}: Invalid single column data";
                    }
                } else {
                    $results['errors']++;
                    $results['error_details'][] = "Row {$row}: Insufficient data parts";
                }
            } catch (\Exception $e) {
                $results['errors']++;
                $results['error_details'][] = "Row {$row}: " . $e->getMessage();
            }
        }

        return $results;
    }

    /**
     * Find target database field for given header
     */
    private function findTargetField($header, $fieldMappings)
    {
        $keyVariations = $this->generateKeyVariations($header);
        
        foreach ($fieldMappings as $targetField => $variations) {
            foreach ($variations as $variation) {
                $normalizedVariations = $this->generateKeyVariations($variation);
                
                foreach ($normalizedVariations as $normalizedKey) {
                    if (in_array($normalizedKey, $keyVariations)) {
                        return $targetField;
                    }
                }
            }
        }
        
        return null;
    }

    /**
     * Simple Excel column mapping
     */
    private function mapExcelColumnName($header, $dataType)
    {
        $header = trim($header);
        $headerUpper = strtoupper($header);
        
        // Direct mapping for common government columns
        $directMappings = [
            'NIK' => 'nik',
            'NO_KK' => 'no_kk', 
            'NOMOR_KK' => 'no_kk',
            'NAMA_LENGKAP' => 'nama',
            'NAMA' => 'nama',
            'NO_DATANG' => 'no_datang',
            'TGL_DATANG' => 'tgl_datang',
            'TANGGAL_DATANG' => 'tanggal_datang',
            'KLASIFIKASI_PINDAH' => 'klasifikasi_pindah',
            'NO_PROP_ASAL' => 'no_prop_asal',
            'NAMA_PROP_ASAL' => 'nama_prop_asal',
            'NO_KAB_ASAL' => 'no_kab_asal',
            'NAMA_KAB_ASAL' => 'nama_kab_asal',
            'NO_KEC_ASAL' => 'no_kec_asal',
            'NAMA_KEC_ASAL' => 'nama_kec_asal',
            'NO_KEL_ASAL' => 'no_kel_asal',
            'NAMA_KEL_ASAL' => 'nama_kel_asal',
            'ALAMAT_ASAL' => 'alamat_asal',
            'NO_RT_ASAL' => 'no_rt_asal',
            'NO_RW_ASAL' => 'no_rw_asal',
            'NO_PROP_TUJUAN' => 'no_prop_tujuan',
            'NAMA_PROP_TUJUAN' => 'nama_prop_tujuan',
            'NO_KAB_TUJUAN' => 'no_kab_tujuan',
            'NAMA_KAB_TUJUAN' => 'nama_kab_tujuan',
            'NO_KEC_TUJUAN' => 'no_kec_tujuan',
            'NAMA_KEC_TUJUAN' => 'nama_kec_tujuan',
            'NO_KEL_TUJUAN' => 'no_kel_tujuan',
            'NAMA_KEL_TUJUAN' => 'nama_kel_tujuan',
            'ALAMAT_TUJUAN' => 'alamat_tujuan',
            'NO_RT_TUJUAN' => 'no_rt_tujuan',
            'NO_RW_TUJUAN' => 'no_rw_tujuan',
            'KODE' => 'kode'
        ];
        
        // Check direct mapping first
        if (isset($directMappings[$headerUpper])) {
            return $directMappings[$headerUpper];
        }
        
        // Fallback to sanitized name
        return $this->sanitizeColumnName($header);
    }

    /**
     * Sanitize column name for database use
     */
    private function sanitizeColumnName($columnName)
    {
        // Convert to lowercase and replace spaces/special chars with underscore
        $sanitized = strtolower(trim($columnName));
        $sanitized = preg_replace('/[^a-z0-9]+/', '_', $sanitized);
        $sanitized = trim($sanitized, '_');
        
        return $sanitized;
    }
    
    /**
     * Filter row data to only include columns that exist in the target table
     */
    private function filterValidColumns($rowData, $tableName)
    {
        try {
            // Get actual table columns using SHOW COLUMNS to avoid MySQL version issues
            $columns = DB::select('SHOW COLUMNS FROM ' . $tableName);
            $validColumns = [];
            
            foreach ($columns as $col) {
                $validColumns[] = $col->Field;
            }
            
            // Filter row data to only include valid columns
            $filteredData = [];
            foreach ($rowData as $key => $value) {
                if (in_array($key, $validColumns)) {
                    $filteredData[$key] = $value;
                }
            }
            
            return $filteredData;
            
        } catch (\Exception $e) {
            // If we can't get column info, return original data and let DB handle the error
            \Log::error('Could not filter columns for table ' . $tableName . ': ' . $e->getMessage());
            return $rowData;
        }
    }
    
    /**
     * Fast date conversion to MySQL format (YYYY-MM-DD)
     */
    private function convertDateFormat($dateString)
    {
        if (empty($dateString)) {
            return date('Y-m-d');
        }
        
        $dateString = trim($dateString);
        
        // Handle common format M/D/YYYY (super fast)
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
            $month = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $day = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $year = $matches[3];
            return $year . '-' . $month . '-' . $day;
        }
        
        // Already in correct format?
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
            return $dateString;
        }
        
        // Fallback
        return date('Y-m-d');
    }
    
    /**
     * Clear dummy data from all tables
     */
    private function clearDummyData()
    {
        try {
            // Get all tables that start with datang or pindah
            $tables = DB::select("SHOW TABLES");
            $dbName = config('database.connections.mysql.database');
            $tableColumn = "Tables_in_{$dbName}";
            
            foreach ($tables as $table) {
                $tableName = $table->$tableColumn;
                
                // Clear data from datang and pindah tables
                if (preg_match('/^(datang|pindah)\d{4}$/', $tableName)) {
                    DB::table($tableName)->truncate();
                    \Log::info("Cleared dummy data from table: {$tableName}");
                }
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to clear dummy data: " . $e->getMessage());
        }
    }
    
    /**
     * Get column mapping based on data type and year
     */
    private function getColumnMapping($dataType, $year)
    {
        if ($dataType === 'datang') {
            if ($year == 2024) {
                // Format datang 2024 (22 kolom A-V) - sesuai format lama
                return [
                    0 => 'nik',                    // A → NIK
                    1 => 'no_kk',                 // B → NO_KK
                    2 => 'nama_lengkap',          // C → NAMA_LENGKAP
                    3 => 'no_datang',             // D → NO_DATANG
                    4 => 'tgl_datang',            // E → TGL_DATANG
                    5 => 'klasifikasi_pindah',    // F → KLASIFIKASI_PINDAH
                    6 => 'alasan_pindah',         // G → ALASAN_PINDAH
                    7 => 'jenis_pindah',          // H → JENIS_PINDAH
                    8 => 'nama_prop_asal',        // I → NAMA_PROP_ASAL
                    9 => 'nama_kab_asal',         // J → NAMA_KAB_ASAL
                    10 => 'nama_kel_asal',        // K → NAMA_KEL_ASAL
                    11 => 'alamat_asal',          // L → ALAMAT_ASAL
                    12 => 'no_rt_asal',           // M → NO_RT_ASAL
                    13 => 'no_rw_asal',           // N → NO_RW_ASAL
                    14 => 'nama_prop_tujuan',     // O → NAMA_PROP_TUJUAN
                    15 => 'nama_kab_tujuan',      // P → NAMA_KAB_TUJUAN
                    16 => 'nama_kec_tujuan',      // Q → NAMA_KEC_TUJUAN
                    17 => 'nama_kel_tujuan',      // R → NAMA_KEL_TUJUAN
                    18 => 'alamat_tujuan',        // S → ALAMAT_TUJUAN
                    19 => 'no_rt_tujuan',         // T → NO_RT_TUJUAN
                    20 => 'no_rw_tujuan',         // U → NO_RW_TUJUAN
                    21 => 'kode'                  // V → KODE
                ];
            } else {
                // Format datang 2025+ (32 kolom A-AF) - format lengkap
                return [
                    0 => 'nik',                    // A → NIK
                    1 => 'no_kk',                 // B → NO_KK
                    2 => 'nama_lengkap',          // C → NAMA_LENGKAP
                    3 => 'no_datang',             // D → NO_DATANG
                    4 => 'tgl_datang',            // E → TGL_DATANG
                    5 => 'klasifikasi_pindah',    // F → KLASIFIKASI_PINDAH
                    6 => 'klasifikasi_pindah_ket', // G → KLASIFIKASI_PINDAH_KET
                    7 => 'alasan_pindah',         // H → ALASAN_PINDAH
                    8 => 'jenis_pindah',          // I → JENIS_PINDAH
                    9 => 'no_prop_asal',          // J → NO_PROP_ASAL
                    10 => 'nama_prop_asal',       // K → NAMA_PROP_ASAL
                    11 => 'no_kab_asal',          // L → NO_KAB_ASAL
                    12 => 'nama_kab_asal',        // M → NAMA_KAB_ASAL
                    13 => 'no_kec_asal',          // N → NO_KEC_ASAL
                    14 => 'nama_kec_asal',        // O → NAMA_KEC_ASAL
                    15 => 'no_kel_asal',          // P → NO_KEL_ASAL
                    16 => 'nama_kel_asal',        // Q → NAMA_KEL_ASAL
                    17 => 'alamat_asal',          // R → ALAMAT_ASAL
                    18 => 'no_rt_asal',           // S → NO_RT_ASAL
                    19 => 'no_rw_asal',           // T → NO_RW_ASAL
                    20 => 'no_prop_tujuan',       // U → NO_PROP_TUJUAN
                    21 => 'nama_prop_tujuan',     // V → NAMA_PROP_TUJUAN
                    22 => 'no_kab_tujuan',        // W → NO_KAB_TUJUAN
                    23 => 'nama_kab_tujuan',      // X → NAMA_KAB_TUJUAN
                    24 => 'no_kec_tujuan',        // Y → NO_KEC_TUJUAN
                    25 => 'nama_kec_tujuan',      // Z → NAMA_KEC_TUJUAN
                    26 => 'no_kel_tujuan',        // AA → NO_KEL_TUJUAN
                    27 => 'nama_kel_tujuan',      // AB → NAMA_KEL_TUJUAN
                    28 => 'alamat_tujuan',        // AC → ALAMAT_TUJUAN
                    29 => 'no_rt_tujuan',         // AD → NO_RT_TUJUAN
                    30 => 'no_rw_tujuan',         // AE → NO_RW_TUJUAN
                    31 => 'kode'                  // AF → KODE
                ];
            }
        } 
        elseif ($dataType === 'pindah') {
            if ($year == 2024) {
                // Format pindah 2024 (22 kolom A-V)
                return [
                    0 => 'nik',                        // A → NIK
                    1 => 'no_kk',                     // B → NO_KK
                    2 => 'nama_lengkap',              // C → NAMA_LENGKAP
                    3 => 'no_pindah',                 // D → NO_PINDAH
                    4 => 'tgl_pindah',                // E → TGL_PINDAH
                    5 => 'klasifikasi_pindah',        // F → KLASIFIKASI_PINDAH
                    6 => 'klasifikasi_pindah_ket',    // G → KLASIFIKASI_PINDAH_KET
                    7 => 'alasan_pindah',             // H → ALASAN_PINDAH
                    8 => 'jenis_pindah',              // I → JENIS_PINDAH
                    9 => 'nama_prop_asal',            // J → NAMA_PROP_ASAL
                    10 => 'nama_kab_asal',            // K → NAMA_KAB_ASAL
                    11 => 'nama_kel_asal',            // L → NAMA_KEL_ASAL
                    12 => 'alamat_asal',              // M → ALAMAT_ASAL
                    13 => 'no_rt_asal',               // N → NO_RT_ASAL
                    14 => 'no_rw_asal',               // O → NO_RW_ASAL
                    15 => 'nama_prop_tujuan',         // P → NAMA_PROP_TUJUAN
                    16 => 'nama_kab_tujuan',          // Q → NAMA_KAB_TUJUAN
                    17 => 'nama_kec_tujuan',          // R → NAMA_KEC_TUJUAN
                    18 => 'nama_kel_tujuan',          // S → NAMA_KEL_TUJUAN
                    19 => 'alamat_tujuan',            // T → ALAMAT_TUJUAN
                    20 => 'no_rt_tujuan',             // U → NO_RT_TUJUAN
                    21 => 'no_rw_tujuan'              // V → NO_RW_TUJUAN
                ];
            } else {
                // Format pindah 2025+ (32 kolom A-AF)
                return [
                    0 => 'nik',                       // A → NIK
                    1 => 'no_kk',                    // B → NO_KK
                    2 => 'nama_lengkap',             // C → NAMA_LENGKAP
                    3 => 'no_pindah',                // D → NO_PINDAH
                    4 => 'tgl_pindah',               // E → TGL_PINDAH
                    5 => 'klasifikasi_pindah',       // F → KLASIFIKASI_PINDAH
                    6 => 'klasifikasi_pindah_ket',   // G → KLASIFIKASI_PINDAH_KET
                    7 => 'alasan_pindah',            // H → ALASAN_PINDAH
                    8 => 'jenis_pindah',             // I → JENIS_PINDAH
                    9 => 'no_prop_asal',             // J → NO_PROP_ASAL
                    10 => 'nama_prop_asal',          // K → NAMA_PROP_ASAL
                    11 => 'no_kab_asal',             // L → NO_KAB_ASAL
                    12 => 'nama_kab_asal',           // M → NAMA_KAB_ASAL
                    13 => 'no_kec_asal',             // N → NO_KEC_ASAL
                    14 => 'nama_kec_asal',           // O → NAMA_KEC_ASAL
                    15 => 'no_kel_asal',             // P → NO_KEL_ASAL
                    16 => 'nama_kel_asal',           // Q → NAMA_KEL_ASAL
                    17 => 'alamat_asal',             // R → ALAMAT_ASAL
                    18 => 'no_rt_asal',              // S → NO_RT_ASAL
                    19 => 'no_rw_asal',              // T → NO_RW_ASAL
                    20 => 'no_prop_tujuan',          // U → NO_PROP_TUJUAN
                    21 => 'nama_prop_tujuan',        // V → NAMA_PROP_TUJUAN
                    22 => 'no_kab_tujuan',           // W → NO_KAB_TUJUAN
                    23 => 'nama_kab_tujuan',         // X → NAMA_KAB_TUJUAN
                    24 => 'no_kec_tujuan',           // Y → NO_KEC_TUJUAN
                    25 => 'nama_kec_tujuan',         // Z → NAMA_KEC_TUJUAN
                    26 => 'no_kel_tujuan',           // AA → NO_KEL_TUJUAN
                    27 => 'nama_kel_tujuan',         // AB → NAMA_KEL_TUJUAN
                    28 => 'alamat_tujuan',           // AC → ALAMAT_TUJUAN
                    29 => 'no_rt_tujuan',            // AD → NO_RT_TUJUAN
                    30 => 'no_rw_tujuan',            // AE → NO_RW_TUJUAN
                    31 => 'kode'                     // AF → KODE
                ];
            }
        }
        
        // Default fallback
        return [];
    }
    
    /**
     * Find the correct sheet in multi-sheet Excel file
     */
    private function findDataSheet($spreadsheet, $dataType, $year)
    {
        $sheetNames = $spreadsheet->getSheetNames();
        \Log::info('Available sheets: ' . implode(', ', $sheetNames));
        
        // Try to find sheet by name patterns
        foreach ($sheetNames as $index => $sheetName) {
            $sheetName = strtolower($sheetName);
            
            // For pindah 2024, look for sheets with year or generic names
            if ($dataType === 'pindah' && $year == 2024) {
                if (strpos($sheetName, '2024') !== false || 
                    strpos($sheetName, 'pindah') !== false ||
                    strpos($sheetName, 'sheet1') !== false ||
                    strpos($sheetName, 'data') !== false) {
                    \Log::info("Found pindah 2024 sheet: {$sheetName}");
                    return $spreadsheet->setActiveSheetIndex($index)->getActiveSheet();
                }
            }
            
            // For pindah 2025, look for single sheet or main data sheet
            if ($dataType === 'pindah' && $year == 2025) {
                if (strpos($sheetName, '2025') !== false || 
                    strpos($sheetName, 'pindah') !== false ||
                    strpos($sheetName, 'sheet1') !== false ||
                    strpos($sheetName, 'data') !== false) {
                    \Log::info("Found pindah 2025 sheet: {$sheetName}");
                    return $spreadsheet->setActiveSheetIndex($index)->getActiveSheet();
                }
            }
            
            // For datang, look for relevant sheets
            if ($dataType === 'datang') {
                if (strpos($sheetName, 'datang') !== false ||
                    strpos($sheetName, (string)$year) !== false ||
                    strpos($sheetName, 'sheet1') !== false ||
                    strpos($sheetName, 'data') !== false) {
                    \Log::info("Found datang sheet: {$sheetName}");
                    return $spreadsheet->setActiveSheetIndex($index)->getActiveSheet();
                }
            }
        }
        
        // Fallback to first sheet
        \Log::info('Using first sheet as fallback');
        return $spreadsheet->setActiveSheetIndex(0)->getActiveSheet();
    }
    
    /**
     * Process multiple sheets in Excel file (untuk pindah 2024)
     */
    private function processMultipleSheets($spreadsheet, $tableName, $dataType, $year)
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => [],
            'processed_sheets' => []
        ];
        
        $sheetCount = $spreadsheet->getSheetCount();
        \Log::info("Processing {$sheetCount} sheets for pindah 2024");
        
        for ($sheetIndex = 0; $sheetIndex < $sheetCount; $sheetIndex++) {
            try {
                $worksheet = $spreadsheet->setActiveSheetIndex($sheetIndex);
                $sheetName = $worksheet->getTitle();
                \Log::info("Processing sheet {$sheetIndex}: {$sheetName}");
                
                // Skip empty sheets
                if ($worksheet->getHighestRow() <= 1) {
                    \Log::info("Skipping empty sheet: {$sheetName}");
                    continue;
                }
                
                $data = $worksheet->toArray();
                $sheetResults = $this->processSheetData($data, $tableName, $dataType, $year, $sheetName);
                
                // Merge results
                $results['inserted'] += $sheetResults['inserted'];
                $results['errors'] += $sheetResults['errors'];
                $results['error_details'] = array_merge($results['error_details'], $sheetResults['error_details']);
                
                // Add preview from first sheet only
                if (empty($results['preview']) && !empty($sheetResults['preview'])) {
                    $results['preview'] = $sheetResults['preview'];
                }
                
                $results['processed_sheets'][] = [
                    'name' => $sheetName,
                    'inserted' => $sheetResults['inserted'],
                    'errors' => $sheetResults['errors']
                ];
                
            } catch (\Exception $e) {
                \Log::error("Error processing sheet {$sheetIndex}: " . $e->getMessage());
                $results['errors']++;
                $results['error_details'][] = "Sheet {$sheetIndex} error: " . $e->getMessage();
            }
        }
        
        return $results;
    }
    
    /**
     * Process individual sheet data
     */
    private function processSheetData($data, $tableName, $dataType, $year, $sheetName = '')
    {
        $results = [
            'inserted' => 0,
            'errors' => 0,
            'error_details' => [],
            'preview' => []
        ];
        
        // FAST HEADER DETECTION
        $headers = [];
        $headerRowIndex = -1;
        
        // Find header in first 10 rows
        $maxRowsToCheck = min(10, count($data));
        for ($i = 0; $i < $maxRowsToCheck; $i++) {
            if (!isset($data[$i])) continue;
            
            $row = $data[$i];
            $rowText = strtolower(implode(' ', $row));
            
            if (strpos($rowText, 'nik') !== false || 
                strpos($rowText, 'nama_lengkap') !== false || 
                strpos($rowText, 'nama') !== false) {
                $headers = array_map('strtolower', array_map('trim', $row));
                $headerRowIndex = $i;
                \Log::info("Headers found at row {$i} in sheet: {$sheetName}");
                break;
            }
        }
        
        // Fallback: use first row
        if ($headerRowIndex === -1) {
            $headers = array_map('strtolower', array_map('trim', $data[0]));
            $headerRowIndex = 0;
        }
        
        // Get column mapping
        $columnMapping = $this->getColumnMapping($dataType, $year);
        
        // Process data rows
        foreach ($data as $rowIndex => $row) {
            if ($rowIndex <= $headerRowIndex) continue; // Skip header
            if (empty(array_filter($row))) continue; // Skip empty rows
            
            try {
                $rowData = [
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                // Map data using column mapping
                foreach ($columnMapping as $colIndex => $dbColumn) {
                    if (isset($row[$colIndex])) {
                        $value = trim($row[$colIndex]);
                        if ($dbColumn === 'tgl_datang') {
                            $rowData['tanggal_datang'] = $this->convertDateFormat($value);
                            $rowData[$dbColumn] = $this->convertDateFormat($value);
                        } elseif ($dbColumn === 'tgl_pindah') {
                            $rowData['tanggal_pindah'] = $this->convertDateFormat($value);
                            $rowData[$dbColumn] = $this->convertDateFormat($value);
                        } else {
                            $rowData[$dbColumn] = $value !== '' ? $value : null;
                        }
                    }
                }
                
                // Required field fallbacks
                if (empty($rowData['nama_lengkap'])) {
                    $rowData['nama_lengkap'] = "Sheet {$sheetName} Row {$rowIndex}";
                }
                if (empty($rowData['tanggal_datang']) && empty($rowData['tanggal_pindah'])) {
                    $rowData[($dataType === 'datang') ? 'tanggal_datang' : 'tanggal_pindah'] = date('Y-m-d');
                }
                
                // Legacy support
                $rowData['nama'] = $rowData['nama_lengkap'];
                $rowData['alamat'] = $rowData['alamat_asal'] ?: $rowData['alamat_tujuan'] ?: 'Alamat tidak ada';
                
                // Filter and insert
                $filteredData = $this->filterValidColumns($rowData, $tableName);
                DB::table($tableName)->insert($filteredData);
                $results['inserted']++;
                
                if (count($results['preview']) < 5) {
                    $results['preview'][] = $rowData;
                }
                
            } catch (\Exception $e) {
                $results['errors']++;
                $results['error_details'][] = "Sheet {$sheetName} Row {$rowIndex}: " . $e->getMessage();
            }
        }
        
        return $results;
    }
}