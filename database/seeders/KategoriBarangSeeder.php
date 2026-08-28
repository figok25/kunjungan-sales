<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = ['Minuman', 'Sembako', 'Snack', 'Rokok'];

        foreach ($kategoris as $nama) {
            KategoriBarang::firstOrCreate(['nama' => $nama]);
        }
    }
}
