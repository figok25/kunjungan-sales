<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMovement extends Model
{
    protected $fillable = [
        'stok_barang_id',
        'tipe',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'user_id',
    ];

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
