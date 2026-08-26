<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $fillable = ['nama_toko', 'alamat', 'no_telp', 'sales_id'];

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }
}
