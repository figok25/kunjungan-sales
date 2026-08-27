<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Toko</label>
                        <select name="toko_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua</option>
                            @foreach ($tokos as $toko)
                                <option value="{{ $toko->id }}" @selected(request('toko_id') == $toko->id)>
                                    {{ $toko->nama_toko }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if (! auth()->user()->isSales())
                        <div>
                            <label class="block text-sm text-gray-600">Sales</label>
                            <select name="sales_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">Semua</option>
                                @foreach ($salesList as $sales)
                                    <option value="{{ $sales->id }}" @selected(request('sales_id') == $sales->id)>
                                        {{ $sales->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                    @if (auth()->user()->isSales())
                        <a href="{{ route('kunjungan.create') }}" class="ml-auto bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">+ Catat Kunjungan</a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Toko</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Sales</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Total</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($kunjungans as $kunjungan)
                            <tr>
                                <td class="px-4 py-3">{{ $kunjungan->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">{{ $kunjungan->toko->nama_toko ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $kunjungan->sales->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($kunjungan->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('kunjungan.show', $kunjungan) }}" class="text-indigo-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data kunjungan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $kunjungans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
