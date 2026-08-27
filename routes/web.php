<?php

use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
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

    Route::middleware('owner_or_admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::middleware('sales_only')->group(function () {
        Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
        Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
    });
    Route::get('/kunjungan/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
});

require __DIR__.'/auth.php';
