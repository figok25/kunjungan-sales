<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private Collection $details)
    {
    }

    public function collection(): Collection
    {
        return $this->details;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Toko',
            'Sales',
            'Barang',
            'Kategori',
            'Qty',
            'Harga Satuan',
            'Subtotal',
        ];
    }

    public function map($detail): array
    {
        return [
            $detail->kunjungan->created_at->format('d-m-Y H:i'),
            $detail->kunjungan->toko->nama_toko ?? '-',
            $detail->kunjungan->sales->name ?? '-',
            $detail->stokBarang->nama_barang ?? '-',
            $detail->stokBarang->kategori->nama ?? '-',
            $detail->jumlah,
            $detail->harga_satuan,
            $detail->subtotal,
        ];
    }
}
