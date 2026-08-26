<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\StokBarang;
use App\Models\StokMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = StokBarang::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_barang_id', $request->kategori_id);
        }

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $stokBarangs = $query->orderBy('nama_barang')->paginate(15)->withQueryString();
        $kategoris = KategoriBarang::orderBy('nama')->get();

        return view('stok-barang.index', compact('stokBarangs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriBarang::orderBy('nama')->get();

        return view('stok-barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_barang_id' => ['required', 'exists:kategori_barangs,id'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'stok_awal' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $stokBarang = StokBarang::create([
                'kategori_barang_id' => $validated['kategori_barang_id'],
                'nama_barang' => $validated['nama_barang'],
                'stok' => $validated['stok_awal'],
                'harga' => $validated['harga'],
            ]);

            if ($validated['stok_awal'] > 0) {
                StokMovement::create([
                    'stok_barang_id' => $stokBarang->id,
                    'tipe' => 'masuk',
                    'jumlah' => $validated['stok_awal'],
                    'stok_sebelum' => 0,
                    'stok_sesudah' => $validated['stok_awal'],
                    'keterangan' => 'Stok awal',
                    'user_id' => $request->user()->id,
                ]);
            }
        });

        return redirect()->route('stok-barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(StokBarang $stokBarang)
    {
        $kategoris = KategoriBarang::orderBy('nama')->get();

        return view('stok-barang.edit', compact('stokBarang', 'kategoris'));
    }

    public function update(Request $request, StokBarang $stokBarang)
    {
        $validated = $request->validate([
            'kategori_barang_id' => ['required', 'exists:kategori_barangs,id'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        $stokBarang->update($validated);

        return redirect()->route('stok-barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(StokBarang $stokBarang)
    {
        $stokBarang->delete();

        return redirect()->route('stok-barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function adjustForm(StokBarang $stokBarang)
    {
        return view('stok-barang.adjust', compact('stokBarang'));
    }

    public function adjustStore(Request $request, StokBarang $stokBarang)
    {
        $validated = $request->validate([
            'tipe' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['tipe'] === 'keluar' && $validated['jumlah'] > $stokBarang->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah keluar melebihi stok yang tersedia (' . $stokBarang->stok . ').'])->withInput();
        }

        DB::transaction(function () use ($validated, $stokBarang, $request) {
            $stokSebelum = $stokBarang->stok;
            $stokSesudah = $validated['tipe'] === 'masuk'
                ? $stokSebelum + $validated['jumlah']
                : $stokSebelum - $validated['jumlah'];

            StokMovement::create([
                'stok_barang_id' => $stokBarang->id,
                'tipe' => $validated['tipe'],
                'jumlah' => $validated['jumlah'],
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => $validated['keterangan'] ?? null,
                'user_id' => $request->user()->id,
            ]);

            $stokBarang->update(['stok' => $stokSesudah]);
        });

        return redirect()->route('stok-barang.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function histori(StokBarang $stokBarang)
    {
        $movements = $stokBarang->movements()->with('user')->paginate(20);

        return view('stok-barang.histori', compact('stokBarang', 'movements'));
    }
}
