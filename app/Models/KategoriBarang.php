<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $fillable = ['nama'];

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class);
    }
}
