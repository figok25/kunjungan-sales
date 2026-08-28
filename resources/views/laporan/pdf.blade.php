<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        .meta { color: #6b7280; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        .text-right { text-align: right; }
        .summary { margin-top: 12px; font-size: 13px; }
        .summary strong { display: inline-block; width: 160px; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <div class="meta">Dicetak: {{ now()->format('d M Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Toko</th>
                <th>Sales</th>
                <th>Barang</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($details as $detail)
                <tr>
                    <td>{{ $detail->kunjungan->tanggal_kunjungan->format('d-m-Y H:i') }}</td>
                    <td>{{ $detail->kunjungan->toko->nama_toko ?? '-' }}</td>
                    <td>{{ $detail->kunjungan->sales->name ?? '-' }}</td>
                    <td>{{ $detail->stokBarang->nama_barang ?? '-' }}</td>
                    <td class="text-right">{{ $detail->jumlah }}</td>
                    <td class="text-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div><strong>Total Item Terjual</strong> {{ number_format($summary->total_qty ?? 0) }}</div>
        <div><strong>Total Penjualan</strong> Rp {{ number_format($summary->total_penjualan ?? 0, 0, ',', '.') }}</div>
    </div>
</body>
</html>
