<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stok Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Cari Nama Barang</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Kategori</label>
                        <select name="kategori_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                    @if (! auth()->user()->isSales())
                        <a href="{{ route('stok-barang.create') }}" class="ml-auto bg-teal text-white px-4 py-2 rounded-md text-sm">+ Tambah Barang</a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Barang</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Kategori</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Stok</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Harga</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($stokBarangs as $barang)
                            <tr>
                                <td class="px-4 py-3">{{ $barang->nama_barang }}</td>
                                <td class="px-4 py-3">{{ $barang->kategori->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">{{ $barang->stok }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('stok-barang.histori', $barang) }}" class="text-blue-600 hover:underline">Histori</a>
                                    @if (! auth()->user()->isSales())
                                        <a href="{{ route('stok-barang.adjust', $barang) }}" class="text-emerald-600 hover:underline">Adjust Stok</a>
                                        <a href="{{ route('stok-barang.edit', $barang) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <form action="{{ route('stok-barang.destroy', $barang) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="px-4 py-3">
                    {{ $stokBarangs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
