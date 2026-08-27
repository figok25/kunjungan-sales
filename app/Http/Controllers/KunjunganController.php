<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\KunjunganDetail;
use App\Models\StokBarang;
use App\Models\StokMovement;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['toko', 'sales']);

        $user = $request->user();

        if ($user->isSales()) {
            $query->where('user_id', $user->id);
        } elseif ($request->filled('sales_id')) {
            $query->where('user_id', $request->sales_id);
        }

        if ($request->filled('toko_id')) {
            $query->where('toko_id', $request->toko_id);
        }

        $kunjungans = $query->latest()->paginate(15)->withQueryString();
        $tokos = Toko::orderBy('nama_toko')->get();
        $salesList = User::where('role', 'sales')->orderBy('name')->get();

        return view('kunjungan.index', compact('kunjungans', 'tokos', 'salesList'));
    }

    public function create()
    {
        $tokos = Toko::orderBy('nama_toko')->get();
        $stokBarangs = StokBarang::with('kategori')->orderBy('nama_barang')->get();

        return view('kunjungan.create', compact('tokos', 'stokBarangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'toko_id' => ['required', 'exists:tokos,id'],
            'catatan' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.stok_barang_id' => ['required_with:items', 'exists:stok_barangs,id'],
            'items.*.jumlah' => ['required_with:items', 'integer', 'min:1'],
        ]);

        $items = collect($validated['items'] ?? []);

        $kunjungan = DB::transaction(function () use ($validated, $items, $request) {
            $kunjungan = Kunjungan::create([
                'toko_id' => $validated['toko_id'],
                'user_id' => $request->user()->id,
                'catatan' => $validated['catatan'] ?? null,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $stokBarang = StokBarang::lockForUpdate()->findOrFail($item['stok_barang_id']);

                if ($item['jumlah'] > $stokBarang->stok) {
                    abort(422, 'Stok ' . $stokBarang->nama_barang . ' tidak mencukupi (tersedia ' . $stokBarang->stok . ').');
                }

                $subtotal = $stokBarang->harga * $item['jumlah'];
                $total += $subtotal;

                KunjunganDetail::create([
                    'kunjungan_id' => $kunjungan->id,
                    'stok_barang_id' => $stokBarang->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $stokBarang->harga,
                    'subtotal' => $subtotal,
                ]);

                $stokSebelum = $stokBarang->stok;
                $stokSesudah = $stokSebelum - $item['jumlah'];

                StokMovement::create([
                    'stok_barang_id' => $stokBarang->id,
                    'tipe' => 'keluar',
                    'jumlah' => $item['jumlah'],
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'keterangan' => 'Kunjungan #' . $kunjungan->id,
                    'user_id' => $request->user()->id,
                ]);

                $stokBarang->update(['stok' => $stokSesudah]);
            }

            $kunjungan->update(['total' => $total]);

            return $kunjungan;
        });

        return redirect()->route('kunjungan.show', $kunjungan)->with('success', 'Kunjungan berhasil dicatat.');
    }

    public function show(Request $request, Kunjungan $kunjungan)
    {
        $user = $request->user();

        if ($user->isSales() && $kunjungan->user_id !== $user->id) {
            abort(403, 'Kamu hanya dapat melihat kunjungan milikmu sendiri.');
        }

        $kunjungan->load(['toko', 'sales', 'details.stokBarang']);

        return view('kunjungan.show', compact('kunjungan'));
    }
}
