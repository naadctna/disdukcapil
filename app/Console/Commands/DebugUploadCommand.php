<?php

use Illuminate\Console\Command;

class DebugUploadCommand extends Command
{
    protected $signature = 'debug:upload';
    protected $description = 'Debug upload functionality';
    
    public function handle()
    {
        $this->info('Starting debug upload...');
        
        $filePath = public_path('test_upload_pindah2024.csv');
        
        if (!file_exists($filePath)) {
            $this->error('File test tidak ditemukan!');
            return 1;
        }
        
        $this->info('File exists: ' . $filePath);
        
        // Simulate file upload
        $file = new \Illuminate\Http\UploadedFile(
            $filePath,
            'test_upload_pindah2024.csv',
            'text/csv',
            null,
            true
        );
        
        $controller = new \App\Http\Controllers\ExcelUploadController();
        
        try {
            $result = $controller->processExcelFile($file, 'pindah2024', 'pindah', 2024);
            
            $this->info('Upload result:');
            $this->info(json_encode($result, JSON_PRETTY_PRINT));
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Upload failed: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}