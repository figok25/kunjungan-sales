<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use App\Models\StokBarang;
use App\Models\StokMovement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerId = User::where('role', 'owner')->value('id');

        $data = [
            'Minuman' => [
                ['nama' => 'Teh Kotak 250ml', 'stok' => 120, 'harga' => 4000],
                ['nama' => 'Air Mineral 600ml', 'stok' => 150, 'harga' => 3000],
                ['nama' => 'Kopi Sachet Renceng', 'stok' => 80, 'harga' => 15000],
            ],
            'Sembako' => [
                ['nama' => 'Beras 5kg', 'stok' => 40, 'harga' => 65000],
                ['nama' => 'Minyak Goreng 1L', 'stok' => 60, 'harga' => 18000],
                ['nama' => 'Gula Pasir 1kg', 'stok' => 70, 'harga' => 16000],
            ],
            'Snack' => [
                ['nama' => 'Biskuit Kaleng', 'stok' => 35, 'harga' => 22000],
                ['nama' => 'Keripik Kentang', 'stok' => 50, 'harga' => 9000],
            ],
            'Rokok' => [
                ['nama' => 'Rokok Filter Isi 16', 'stok' => 90, 'harga' => 24000],
                ['nama' => 'Rokok Filter Isi 12', 'stok' => 90, 'harga' => 19000],
            ],
        ];

        foreach ($data as $namaKategori => $barangs) {
            $kategori = KategoriBarang::where('nama', $namaKategori)->first();

            if (! $kategori) {
                continue;
            }

            foreach ($barangs as $item) {
                $stokBarang = StokBarang::firstOrCreate(
                    ['nama_barang' => $item['nama'], 'kategori_barang_id' => $kategori->id],
                    ['stok' => $item['stok'], 'harga' => $item['harga']]
                );

                if ($stokBarang->wasRecentlyCreated) {
                    StokMovement::create([
                        'stok_barang_id' => $stokBarang->id,
                        'tipe' => 'masuk',
                        'jumlah' => $item['stok'],
                        'stok_sebelum' => 0,
                        'stok_sesudah' => $item['stok'],
                        'keterangan' => 'Stok awal',
                        'user_id' => $ownerId,
                    ]);
                }
            }
        }
    }
}
