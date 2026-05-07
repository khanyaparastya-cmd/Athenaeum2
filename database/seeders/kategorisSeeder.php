<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kategorisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            [
                'nama_kategori' => 'Novel', 
                'keterangan' => 'Buku cerita', 
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_kategori' => 'Pelajaran', 
                'keterangan' => 'Buku sekolah', 
                'created_at' => now(), 
                'updated_at' => now()],
            [
                'nama_kategori' => 'Komik', 
                'keterangan' => 'Buku bergambar', 
                'created_at' => now(), 
                'updated_at' => now()

            ],
        ]);
    }
}
