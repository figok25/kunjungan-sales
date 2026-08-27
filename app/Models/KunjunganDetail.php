<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganDetail extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'stok_barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class);
    }
}
