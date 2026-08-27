<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $fillable = [
        'toko_id',
        'user_id',
        'catatan',
        'total',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(KunjunganDetail::class);
    }
}
