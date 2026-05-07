<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class siswasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswas')->insert([
            [
                'nama' => 'Andi',
                'nis' => '1001',
                'kelas' => 'X RPL 1',
                'jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi',
                'nis' => '1002',
                'kelas' => 'X RPL 2',
                'jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now()
                
            ],
            [
                'nama' => 'Citra',
                'nis' => '1003',
                'kelas' => 'XI RPL 1',
                'jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dina',
                'nis' => '1004',
                'kelas' => 'XI RPL 2',
                'jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Eka',
                'nis' => '1005',
                'kelas' => 'XII RPL',
                'jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
