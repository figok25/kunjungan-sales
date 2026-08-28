<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-2">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Toko</p>
                        <p class="font-medium">{{ $kunjungan->toko->nama_toko }}</p>
                        <p class="text-gray-500 text-xs">{{ $kunjungan->toko->alamat }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Sales</p>
                        <p class="font-medium">{{ $kunjungan->sales->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal</p>
                        <p class="font-medium">{{ $kunjungan->tanggal_kunjungan->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Transaksi</p>
                        <p class="font-medium">Rp {{ number_format($kunjungan->total, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($kunjungan->catatan)
                    <div class="pt-2">
                        <p class="text-gray-500 text-sm">Catatan</p>
                        <p class="text-sm">{{ $kunjungan->catatan }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Barang</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Qty</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Harga Satuan</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($kunjungan->details as $detail)
                            <tr>
                                <td class="px-4 py-3">{{ $detail->stokBarang->nama_barang ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">{{ $detail->jumlah }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Kunjungan ini tidak ada transaksi barang (survei/follow-up).</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($kunjungan->details->isNotEmpty())
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-medium">Total</td>
                                <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($kunjungan->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
                </div>
            </div>

            <a href="{{ route('kunjungan.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali ke Daftar Kunjungan</a>
        </div>
    </div>
</x-app-layout>
