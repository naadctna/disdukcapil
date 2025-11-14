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
        
        // SUPER ROBUST MAPPING SYSTEM - handle EXACT government variations like NO_KK, NOMOR_KK
        
        // Build associative array dari headers dan data dengan normalisasi advanced
        $rowData = [];
        for ($i = 0; $i < count($headers); $i++) {
            $originalKey = trim($headers[$i]);
            $value = isset($data[$i]) ? trim($data[$i]) : '';
            
            // Store with multiple key variations untuk maximum compatibility
            $keyVariations = $this->generateKeyVariations($originalKey);
            foreach ($keyVariations as $keyVar) {
                $rowData[$keyVar] = $value;
            }
        }
        
        // COMPREHENSIVE FIELD MAPPINGS - covers ALL possible variations
        $fieldMappings = $this->getComprehensiveFieldMappings($dataType);
        
        // Try to map each required field dengan prioritas
        foreach ($fieldMappings as $targetField => $variations) {
            $mapped[$targetField] = null;
            
            // Try exact matches first dengan berbagai normalisasi
            foreach ($variations as $variation) {
                $normalizedVariations = $this->generateKeyVariations($variation);
                
                foreach ($normalizedVariations as $normalizedKey) {
                    if (isset($rowData[$normalizedKey]) && !empty($rowData[$normalizedKey]) && $rowData[$normalizedKey] !== '-' && $rowData[$normalizedKey] !== 'null') {
                        $value = $rowData[$normalizedKey];
                        $mapped[$targetField] = $this->processFieldValue($targetField, $value);
                        break 2; // Break dari kedua loop
                    }
                }
            }
            
            // Fallback: fuzzy matching untuk field critical
            if (empty($mapped[$targetField])) {
                $mapped[$targetField] = $this->fuzzyFieldMatch($rowData, $variations, $targetField);
            }
        }
        
        // FINAL FALLBACK SYSTEM - intelligent guessing
        $this->applyIntelligentFallback($rowData, $mapped, $dataType);
        
        return $mapped;
    }
    
    /**
     * Generate ALL possible key variations for flexible matching
     * Handles: NO_KK, NOMOR_KK, nokk, nomorKK, No KK, etc.
     */
    private function generateKeyVariations($key)
    {
        $variations = [];
        $cleanKey = trim($key);
        
        // Original key
        $variations[] = $cleanKey;
        
        // Lowercase version
        $variations[] = strtolower($cleanKey);
        
        // Uppercase version  
        $variations[] = strtoupper($cleanKey);
        
        // Remove all spaces, underscores, dashes, dots
        $noSpaces = str_replace([' ', '_', '-', '.', '(', ')', '[', ']'], '', $cleanKey);
        $variations[] = $noSpaces;
        $variations[] = strtolower($noSpaces);
        $variations[] = strtoupper($noSpaces);
        
        // Replace underscores with spaces and vice versa
        $withSpaces = str_replace(['_', '-', '.'], ' ', $cleanKey);
        $variations[] = $withSpaces;
        $variations[] = strtolower($withSpaces);
        
        $withUnderscores = str_replace([' ', '-', '.'], '_', $cleanKey);
        $variations[] = $withUnderscores;
        $variations[] = strtolower($withUnderscores);
        $variations[] = strtoupper($withUnderscores);
        
        // Common patterns untuk government files
        $patterns = [
            'NO_' => ['NO_', 'NOMOR_', 'NUMBER_', 'No_', 'Nomor_', 'no_', 'nomor_', 'No ', 'Nomor ', 'NO ', 'NOMOR '],
            'TGL_' => ['TGL_', 'TANGGAL_', 'DATE_', 'Tgl_', 'Tanggal_', 'tgl_', 'tanggal_', 'Tgl ', 'Tanggal ', 'TGL ', 'TANGGAL '],
            'JML_' => ['JML_', 'JUMLAH_', 'TOTAL_', 'Jml_', 'Jumlah_', 'jml_', 'jumlah_', 'Jml ', 'Jumlah ', 'JML ', 'JUMLAH ']
        ];
        
        foreach ($patterns as $pattern => $replacements) {
            if (strpos(strtoupper($cleanKey), $pattern) !== false) {
                foreach ($replacements as $replacement) {
                    $newKey = str_ireplace($pattern, $replacement, $cleanKey);
                    $variations[] = $newKey;
                    $variations[] = strtolower($newKey);
                    $variations[] = strtoupper($newKey);
                    
                    // Also version tanpa spaces/underscores
                    $clean = str_replace([' ', '_', '-', '.'], '', $newKey);
                    $variations[] = $clean;
                    $variations[] = strtolower($clean);
                    $variations[] = strtoupper($clean);
                }
            }
        }
        
        // Remove duplicates
        return array_unique($variations);
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
     * Get comprehensive field mappings for ALL possible variations
     */
    private function getComprehensiveFieldMappings($dataType)
    {
        $mappings = [
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
        
        // At minimum, we need some form of identification (nama OR nik)
        $hasIdentification = !empty($rowData['nama']) || !empty($rowData['nik']);
        
        if (!$hasIdentification) {
            return false;
        }
        
        // For 'datang': just need identification
        if ($dataType == 'datang') {
            return true; // Very permissive - any data with name/nik is valid
        }
        
        // For 'pindah': just need identification  
        if ($dataType == 'pindah') {
            return true; // Very permissive - any data with name/nik is valid
        }
        
        return true;
    }
}