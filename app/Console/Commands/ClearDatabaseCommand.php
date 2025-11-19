<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all data from datang and pindah tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Starting database cleanup...');
        
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableColumn = "Tables_in_{$dbName}";
            $cleared = 0;
            $totalRecords = 0;
            
            foreach ($tables as $table) {
                $tableName = $table->$tableColumn;
                
                // Clear datang and pindah tables
                if (preg_match('/^(datang|pindah)\d{4}$/', $tableName)) {
                    $count = DB::table($tableName)->count();
                    if ($count > 0) {
                        DB::table($tableName)->truncate();
                        $this->line("✅ Cleared table {$tableName}: {$count} records");
                        $totalRecords += $count;
                    } else {
                        $this->line("📄 Table {$tableName}: already empty");
                    }
                    $cleared++;
                }
            }
            
            $this->newLine();
            $this->info("🎉 Database cleanup completed!");
            $this->info("📊 Tables processed: {$cleared}");
            $this->info("🗑️ Total records cleared: {$totalRecords}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
    }
}
