<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $query = Toko::with('sales');

        if ($request->filled('search')) {
            $query->where('nama_toko', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sales_id')) {
            $query->where('sales_id', $request->sales_id);
        }

        $tokos = $query->orderBy('nama_toko')->paginate(15)->withQueryString();
        $salesList = User::where('role', 'sales')->orderBy('name')->get();

        return view('toko.index', compact('tokos', 'salesList'));
    }

    public function create()
    {
        $salesList = User::where('role', 'sales')->orderBy('name')->get();

        return view('toko.create', compact('salesList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:20'],
            'sales_id' => ['nullable', 'exists:users,id'],
        ]);

        Toko::create($validated);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function edit(Toko $toko)
    {
        $salesList = User::where('role', 'sales')->orderBy('name')->get();

        return view('toko.edit', compact('toko', 'salesList'));
    }

    public function update(Request $request, Toko $toko)
    {
        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:20'],
            'sales_id' => ['nullable', 'exists:users,id'],
        ]);

        $toko->update($validated);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy(Toko $toko)
    {
        if ($toko->kunjungans()->exists()) {
            return back()->with('error', 'Toko tidak bisa dihapus karena sudah memiliki histori kunjungan.');
        }

        $toko->delete();

        return redirect()->route('toko.index')->with('success', 'Toko berhasil dihapus.');
    }
}
