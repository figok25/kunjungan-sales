<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Toko</label>
                        <select name="toko_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua</option>
                            @foreach ($tokos as $toko)
                                <option value="{{ $toko->id }}" @selected(request('toko_id') == $toko->id)>{{ $toko->nama_toko }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Kategori</label>
                        <select name="kategori_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (! auth()->user()->isSales())
                        <div>
                            <label class="block text-sm text-gray-600">Sales</label>
                            <select name="sales_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">Semua</option>
                                @foreach ($salesList as $sales)
                                    <option value="{{ $sales->id }}" @selected(request('sales_id') == $sales->id)>{{ $sales->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>

                    <div class="ml-auto flex gap-2">
                        <a href="{{ route('laporan.export-pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">Export PDF</a>
                        <a href="{{ route('laporan.export-excel', request()->query()) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm">Export Excel</a>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total Item Terjual</p>
                    <p class="text-2xl font-semibold">{{ number_format($summary->total_qty ?? 0) }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total Penjualan</p>
                    <p class="text-2xl font-semibold">Rp {{ number_format($summary->total_penjualan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Toko</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Sales</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Barang</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Qty</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($details as $detail)
                            <tr>
                                <td class="px-4 py-3">{{ $detail->kunjungan->tanggal_kunjungan->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">{{ $detail->kunjungan->toko->nama_toko ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $detail->kunjungan->sales->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $detail->stokBarang->nama_barang ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">{{ $detail->jumlah }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada data penjualan pada filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="px-4 py-3">
                    {{ $details->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
