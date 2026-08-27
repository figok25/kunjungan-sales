<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Stok Barang: semua role boleh lihat & lihat histori, tapi hanya Owner/Admin yang boleh ubah data
    Route::get('/stok-barang', [StokBarangController::class, 'index'])->name('stok-barang.index');
    Route::get('/stok-barang/{stokBarang}/histori', [StokBarangController::class, 'histori'])->name('stok-barang.histori');
    Route::middleware('owner_or_admin')->group(function () {
        Route::get('/stok-barang/create', [StokBarangController::class, 'create'])->name('stok-barang.create');
        Route::post('/stok-barang', [StokBarangController::class, 'store'])->name('stok-barang.store');
        Route::get('/stok-barang/{stokBarang}/edit', [StokBarangController::class, 'edit'])->name('stok-barang.edit');
        Route::put('/stok-barang/{stokBarang}', [StokBarangController::class, 'update'])->name('stok-barang.update');
        Route::delete('/stok-barang/{stokBarang}', [StokBarangController::class, 'destroy'])->name('stok-barang.destroy');
        Route::get('/stok-barang/{stokBarang}/adjust', [StokBarangController::class, 'adjustForm'])->name('stok-barang.adjust');
        Route::post('/stok-barang/{stokBarang}/adjust', [StokBarangController::class, 'adjustStore'])->name('stok-barang.adjust.store');
    });

    // Kategori Barang: sama, read-only untuk Sales
    Route::get('/kategori-barang', [KategoriBarangController::class, 'index'])->name('kategori-barang.index');
    Route::middleware('owner_or_admin')->group(function () {
        Route::get('/kategori-barang/create', [KategoriBarangController::class, 'create'])->name('kategori-barang.create');
        Route::post('/kategori-barang', [KategoriBarangController::class, 'store'])->name('kategori-barang.store');
        Route::get('/kategori-barang/{kategoriBarang}/edit', [KategoriBarangController::class, 'edit'])->name('kategori-barang.edit');
        Route::put('/kategori-barang/{kategoriBarang}', [KategoriBarangController::class, 'update'])->name('kategori-barang.update');
        Route::delete('/kategori-barang/{kategoriBarang}', [KategoriBarangController::class, 'destroy'])->name('kategori-barang.destroy');
    });

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
