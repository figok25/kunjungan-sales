<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBarang::withCount('stokBarangs');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->orderBy('nama')->paginate(15)->withQueryString();

        return view('kategori-barang.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori-barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_barangs,nama'],
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('kategori-barang.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriBarang $kategoriBarang)
    {
        return view('kategori-barang.edit', compact('kategoriBarang'));
    }

    public function update(Request $request, KategoriBarang $kategoriBarang)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_barangs,nama,' . $kategoriBarang->id],
        ]);

        $kategoriBarang->update($validated);

        return redirect()->route('kategori-barang.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriBarang $kategoriBarang)
    {
        if ($kategoriBarang->stokBarangs()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh barang.');
        }

        $kategoriBarang->delete();

        return redirect()->route('kategori-barang.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
