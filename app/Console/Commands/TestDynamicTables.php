<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\DynamicTableService;

class TestDynamicTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:test-dynamic {action=show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test dynamic table creation for years 2020-2030. Use "create" to create all tables, "show" to list existing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $service = new DynamicTableService();
        
        if ($action === 'show') {
            $this->showExistingTables();
        } elseif ($action === 'create') {
            $this->createAllTables($service);
        } else {
            $this->error('Invalid action. Use "show" or "create"');
        }
    }
    
    private function showExistingTables()
    {
        $this->info('📊 Checking existing datang/pindah tables...');
        
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableColumn = "Tables_in_{$dbName}";
            $found = [];
            
            foreach ($tables as $table) {
                $tableName = $table->$tableColumn;
                if (preg_match('/^(datang|pindah)(\d{4})$/', $tableName, $matches)) {
                    $found[] = [
                        'table' => $tableName,
                        'type' => $matches[1],
                        'year' => $matches[2],
                        'count' => DB::table($tableName)->count()
                    ];
                }
            }
            
            if (empty($found)) {
                $this->warn('❌ No datang/pindah tables found in database');
            } else {
                $this->info('✅ Found ' . count($found) . ' tables:');
                $this->table(['Table', 'Type', 'Year', 'Records'], 
                    array_map(fn($t) => [$t['table'], $t['type'], $t['year'], $t['count']], $found)
                );
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
    
    private function createAllTables($service)
    {
        $this->info('🏗️ Creating tables for years 2020-2030...');
        
        $years = range(2020, 2030);
        $types = ['datang', 'pindah'];
        $created = 0;
        
        foreach ($years as $year) {
            foreach ($types as $type) {
                try {
                    $tableName = $service->ensureTableExists($type, $year);
                    $this->line("✅ Table {$tableName} ready");
                    $created++;
                } catch (\Exception $e) {
                    $this->error("❌ Failed to create {$type}{$year}: " . $e->getMessage());
                }
            }
        }
        
        $this->info("🎉 Process completed! {$created} tables ensured.");
        $this->call('db:test-dynamic', ['action' => 'show']);
    }
}
