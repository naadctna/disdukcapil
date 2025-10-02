<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendudukSeeder2 extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Sample data untuk datang2024
        DB::table('datang2024')->insert([
            [
                'nama' => 'Ahmad Susanto',
                'alamat' => 'Jl. Merdeka No. 1',
                'tanggal_datang' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Sudirman No. 25',
                'tanggal_datang' => '2024-03-10',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Diponegoro No. 8',
                'tanggal_datang' => '2024-06-20',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample data untuk datang2025
        DB::table('datang2025')->insert([
            [
                'nama' => 'Rina Handayani',
                'alamat' => 'Jl. Pahlawan No. 12',
                'tanggal_datang' => '2025-02-05',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'alamat' => 'Jl. Kartini No. 7',
                'tanggal_datang' => '2025-04-18',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Maya Sari',
                'alamat' => 'Jl. Gajah Mada No. 30',
                'tanggal_datang' => '2025-07-22',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample data untuk pindah2024
        DB::table('pindah2024')->insert([
            [
                'nama' => 'Joko Widodo',
                'alamat_asal' => 'Jl. Thamrin No. 5',
                'alamat_tujuan' => 'Jl. Kebon Jeruk No. 15',
                'tanggal_pindah' => '2024-02-28',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ani Setiawan',
                'alamat_asal' => 'Jl. Cikini No. 20',
                'alamat_tujuan' => 'Jl. Menteng No. 10',
                'tanggal_pindah' => '2024-05-15',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Sample data untuk pindah2025
        DB::table('pindah2025')->insert([
            [
                'nama' => 'Lisa Permata',
                'alamat_asal' => 'Jl. Kuningan No. 8',
                'alamat_tujuan' => 'Jl. Pondok Indah No. 22',
                'tanggal_pindah' => '2025-01-20',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Andi Prasetyo',
                'alamat_asal' => 'Jl. Pancoran No. 14',
                'alamat_tujuan' => 'Jl. Tebet No. 33',
                'tanggal_pindah' => '2025-03-25',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}