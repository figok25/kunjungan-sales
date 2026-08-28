<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\Kunjungan;
use App\Models\KunjunganDetail;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function filteredQuery(Request $request)
    {
        $user = $request->user();

        $query = KunjunganDetail::with(['kunjungan.toko', 'kunjungan.sales', 'stokBarang.kategori']);

        $query->whereHas('kunjungan', function ($q) use ($request, $user) {
            if ($user->isSales()) {
                $q->where('user_id', $user->id);
            } elseif ($request->filled('sales_id')) {
                $q->where('user_id', $request->sales_id);
            }

            if ($request->filled('toko_id')) {
                $q->where('toko_id', $request->toko_id);
            }

            if ($request->filled('dari_tanggal')) {
                $q->whereDate('tanggal_kunjungan', '>=', $request->dari_tanggal);
            }

            if ($request->filled('sampai_tanggal')) {
                $q->whereDate('tanggal_kunjungan', '<=', $request->sampai_tanggal);
            }
        });

        if ($request->filled('kategori_id')) {
            $query->whereHas('stokBarang', function ($q) use ($request) {
                $q->where('kategori_barang_id', $request->kategori_id);
            });
        }

        return $query;
    }

    private function orderByTanggalKunjungan($query)
    {
        return $query->orderByDesc(
            Kunjungan::select('tanggal_kunjungan')->whereColumn('kunjungans.id', 'kunjungan_details.kunjungan_id')
        );
    }

    public function index(Request $request)
    {
        $details = $this->orderByTanggalKunjungan($this->filteredQuery($request))->paginate(20)->withQueryString();

        $summary = (clone $this->filteredQuery($request))->selectRaw('SUM(jumlah) as total_qty, SUM(subtotal) as total_penjualan')->first();

        $tokos = Toko::orderBy('nama_toko')->get();
        $kategoris = KategoriBarang::orderBy('nama')->get();
        $salesList = User::where('role', 'sales')->orderBy('name')->get();

        return view('laporan.index', compact('details', 'summary', 'tokos', 'kategoris', 'salesList'));
    }

    public function exportPdf(Request $request)
    {
        $details = $this->orderByTanggalKunjungan($this->filteredQuery($request))->get();
        $summary = (clone $this->filteredQuery($request))->selectRaw('SUM(jumlah) as total_qty, SUM(subtotal) as total_penjualan')->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('details', 'summary', 'request'));

        return $pdf->download('laporan-penjualan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $details = $this->orderByTanggalKunjungan($this->filteredQuery($request))->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanPenjualanExport($details),
            'laporan-penjualan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
