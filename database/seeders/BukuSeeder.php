<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::create([
            'judul' => 'Laravel 10',
            'penulis' => 'Taylor'
        ]);

        Buku::create([
            'judul' => 'PHP OOP',
            'penulis' => 'Rudi'
        ]);
    }
}