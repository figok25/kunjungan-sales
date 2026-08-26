<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histori Stok') }} — {{ $stokBarang->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Tipe</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Jumlah</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Sebelum</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Sesudah</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Keterangan</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($movements as $movement)
                            <tr>
                                <td class="px-4 py-3">{{ $movement->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <span class="{{ $movement->tipe === 'masuk' ? 'text-emerald-600' : 'text-red-600' }} font-medium">
                                        {{ ucfirst($movement->tipe) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">{{ $movement->jumlah }}</td>
                                <td class="px-4 py-3 text-right">{{ $movement->stok_sebelum }}</td>
                                <td class="px-4 py-3 text-right">{{ $movement->stok_sesudah }}</td>
                                <td class="px-4 py-3">{{ $movement->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $movement->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada pergerakan stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $movements->links() }}
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('stok-barang.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali ke Stok Barang</a>
            </div>
        </div>
    </div>
</x-app-layout>
