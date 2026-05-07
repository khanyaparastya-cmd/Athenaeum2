<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
  
class bukusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bukus')->insert([
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'kategori_id' => 1,
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'tahun_terbit' => 2014,
                'kategori_id' => 1,
                'stok' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Matematika',
                'penulis' => 'Kemendikbud',
                'tahun_terbit' => 2020,
                'kategori_id' => 2,
                'stok' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'IPA',
                'penulis' => 'Kemendikbud',
                'tahun_terbit' => 2021,
                'kategori_id' => 2,
                'stok' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Naruto',
                'penulis' => 'Masashi Kishimoto',
                'tahun_terbit' => 2010,
                'kategori_id' => 3,
                'stok' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
