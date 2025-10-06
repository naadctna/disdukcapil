<?php

// Test CSV parsing
$file = 'test_upload.csv';

if (($handle = fopen($file, "r")) !== FALSE) {
    $headers = [];
    $rowIndex = 0;
    
    echo "=== CSV PARSING TEST ===\n";
    
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "Row $rowIndex Raw Data: ";
        print_r($data);
        
        if ($rowIndex == 0) {
            $headers = array_map('trim', $data);
            echo "Headers after trim: ";
            print_r($headers);
            $rowIndex++;
            continue;
        }
        
        // Test mapping
        echo "Testing mapping with headers: ";
        print_r($headers);
        echo "With data: ";
        print_r($data);
        
        $mapped = [];
        for ($i = 0; $i < count($headers); $i++) {
            $header = strtolower(trim($headers[$i]));
            $header = str_replace(' ', '_', $header);
            $value = isset($data[$i]) ? trim($data[$i]) : '';
            
            echo "Processing header[$i]: '$header' with value: '$value'\n";
            
            switch ($header) {
                case 'nama':
                case 'nama_lengkap':
                case 'name':
                    $mapped['nama'] = $value;
                    echo "  -> Mapped to nama: $value\n";
                    break;
                    
                case 'alamat':
                case 'address':
                    $mapped['alamat'] = $value;
                    echo "  -> Mapped to alamat: $value\n";
                    break;
                    
                case 'tanggal':
                case 'tanggal_datang':
                case 'tgl_datang':
                case 'date':
                    $mapped['tanggal_datang'] = $value;
                    echo "  -> Mapped to tanggal_datang: $value\n";
                    break;
                    
                default:
                    echo "  -> No mapping found for header: $header\n";
                    break;
            }
        }
        
        echo "Final mapped result: ";
        print_r($mapped);
        echo "\n";
        
        $rowIndex++;
        if ($rowIndex > 2) break; // Only test first 2 data rows
    }
    fclose($handle);
} else {
    echo "Could not open file: $file\n";
}