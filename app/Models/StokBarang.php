<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $fillable = ['kategori_barang_id', 'nama_barang', 'stok', 'harga'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function movements()
    {
        return $this->hasMany(StokMovement::class)->latest();
    }
}
