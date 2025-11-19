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
                        // Extend location code columns to handle both codes and names flexibly
                        $table->string('no_prop_asal', 50)->change();      // Was varchar(2)
                        $table->string('no_kab_asal', 50)->change();       // Was varchar(4) 
                        $table->string('no_kec_asal', 50)->change();       // Was varchar(7)
                        $table->string('no_kel_asal', 50)->change();       // Was varchar(10)
                        $table->string('no_prop_tujuan', 50)->change();    // Was varchar(2)
                        $table->string('no_kab_tujuan', 50)->change();     // Was varchar(4)
                        $table->string('no_kec_tujuan', 50)->change();     // Was varchar(7)
                        $table->string('no_kel_tujuan', 50)->change();     // Was varchar(10)
                    });
                    
                    echo "Extended location columns for table: {$tableName}\n";
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
                        $table->string('no_prop_asal', 2)->change();
                        $table->string('no_kab_asal', 4)->change(); 
                        $table->string('no_kec_asal', 7)->change();
                        $table->string('no_kel_asal', 10)->change();
                        $table->string('no_prop_tujuan', 2)->change();
                        $table->string('no_kab_tujuan', 4)->change();
                        $table->string('no_kec_tujuan', 7)->change();
                        $table->string('no_kel_tujuan', 10)->change();
                    });
                }
            }
        }
    }
};
