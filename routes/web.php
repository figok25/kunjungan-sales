<?php

use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('stok-barang', StokBarangController::class);
    Route::get('/stok-barang/{stokBarang}/adjust', [StokBarangController::class, 'adjustForm'])->name('stok-barang.adjust');
    Route::post('/stok-barang/{stokBarang}/adjust', [StokBarangController::class, 'adjustStore'])->name('stok-barang.adjust.store');
    Route::get('/stok-barang/{stokBarang}/histori', [StokBarangController::class, 'histori'])->name('stok-barang.histori');

    Route::resource('kategori-barang', KategoriBarangController::class)->except(['show']);

    Route::resource('toko', TokoController::class)->except(['show']);
});

require __DIR__.'/auth.php';
