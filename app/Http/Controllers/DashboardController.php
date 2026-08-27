<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\KunjunganDetail;
use App\Models\StokBarang;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $kunjunganQuery = Kunjungan::query();
        $detailQuery = KunjunganDetail::query();

        if ($user->isSales()) {
            $kunjunganQuery->where('user_id', $user->id);
            $detailQuery->whereHas('kunjungan', fn ($q) => $q->where('user_id', $user->id));
        }

        $awalBulan = Carbon::now()->startOfMonth();

        $kunjunganBulanIni = (clone $kunjunganQuery)->where('created_at', '>=', $awalBulan)->count();
        $penjualanBulanIni = (clone $detailQuery)->whereHas('kunjungan', fn ($q) => $q->where('created_at', '>=', $awalBulan))->sum('subtotal');
        $totalToko = $user->isSales() ? Toko::where('sales_id', $user->id)->count() : Toko::count();
        $stokMenipis = StokBarang::where('stok', '<=', 10)->count();

        $chartPenjualan = $this->chartPenjualan14Hari(clone $detailQuery);
        $chartKategori = $this->chartKategoriBulanIni(clone $detailQuery, $awalBulan);

        $kunjunganTerbaru = (clone $kunjunganQuery)->with(['toko', 'sales'])->latest()->take(8)->get();

        return view('dashboard', [
            'kunjunganBulanIni' => $kunjunganBulanIni,
            'penjualanBulanIni' => $penjualanBulanIni,
            'totalToko' => $totalToko,
            'stokMenipis' => $stokMenipis,
            'chartPenjualan' => $chartPenjualan,
            'chartKategori' => $chartKategori,
            'kunjunganTerbaru' => $kunjunganTerbaru,
        ]);
    }

    private function chartPenjualan14Hari($detailQuery): array
    {
        $mulai = Carbon::now()->subDays(13)->startOfDay();

        $rows = (clone $detailQuery)
            ->whereHas('kunjungan', fn ($q) => $q->where('created_at', '>=', $mulai))
            ->with('kunjungan:id,created_at')
            ->get()
            ->groupBy(fn ($detail) => $detail->kunjungan->created_at->format('Y-m-d'));

        $labels = [];
        $data = [];

        for ($i = 0; $i < 14; $i++) {
            $tanggal = $mulai->copy()->addDays($i);
            $key = $tanggal->format('Y-m-d');
            $labels[] = $tanggal->format('d/m');
            $data[] = (float) ($rows[$key] ?? collect())->sum('subtotal');
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function chartKategoriBulanIni($detailQuery, $awalBulan): array
    {
        $rows = (clone $detailQuery)
            ->whereHas('kunjungan', fn ($q) => $q->where('created_at', '>=', $awalBulan))
            ->with('stokBarang.kategori')
            ->get()
            ->groupBy(fn ($detail) => $detail->stokBarang->kategori->nama ?? 'Lainnya');

        return [
            'labels' => $rows->keys()->values()->all(),
            'data' => $rows->map(fn ($group) => (float) $group->sum('subtotal'))->values()->all(),
        ];
    }
}
