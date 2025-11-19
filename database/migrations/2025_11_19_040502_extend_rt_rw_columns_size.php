<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all table names for both datang and pindah from 2020 to 2030
        $dataTypes = ['datang', 'pindah'];
        $years = range(2020, 2030);
        
        foreach ($dataTypes as $dataType) {
            foreach ($years as $year) {
                $tableName = $dataType . $year;
                
                // Check if table exists before modifying
                if (Schema::hasTable($tableName)) {
                    Schema::table($tableName, function (Blueprint $table) {
                        // Extend RT/RW columns to handle longer data
                        $table->string('no_rt_asal', 20)->change();      // Was varchar(3)
                        $table->string('no_rw_asal', 20)->change();      // Was varchar(3)
                        $table->string('no_rt_tujuan', 20)->change();    // Was varchar(3)
                        $table->string('no_rw_tujuan', 20)->change();    // Was varchar(3)
                    });
                    
                    echo "Extended RT/RW columns for table: {$tableName}\n";
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all table names for both datang and pindah from 2020 to 2030
        $dataTypes = ['datang', 'pindah'];
        $years = range(2020, 2030);
        
        foreach ($dataTypes as $dataType) {
            foreach ($years as $year) {
                $tableName = $dataType . $year;
                
                // Check if table exists before modifying
                if (Schema::hasTable($tableName)) {
                    Schema::table($tableName, function (Blueprint $table) {
                        // Revert to original sizes
                        $table->string('no_rt_asal', 3)->change();
                        $table->string('no_rw_asal', 3)->change();
                        $table->string('no_rt_tujuan', 3)->change();
                        $table->string('no_rw_tujuan', 3)->change();
                    });
                }
            }
        }
    }
};
