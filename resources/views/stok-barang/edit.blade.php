<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('stok-barang.update', $stokBarang) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang', $stokBarang->nama_barang) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_barang') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                        <select name="kategori_barang_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_barang_id', $stokBarang->kategori_barang_id) == $kategori->id)>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_barang_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Stok Saat Ini</label>
                        <input type="text" value="{{ $stokBarang->stok }}" disabled class="w-full border-gray-200 bg-gray-100 rounded-md shadow-sm text-gray-500">
                        <p class="text-xs text-gray-500 mt-1">Ubah stok lewat menu <a href="{{ route('stok-barang.adjust', $stokBarang) }}" class="text-indigo-600 hover:underline">Adjust Stok</a>.</p>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Harga</label>
                        <input type="number" min="0" step="0.01" name="harga" value="{{ old('harga', $stokBarang->harga) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('harga') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('stok-barang.index') }}" class="px-4 py-2 rounded-md text-sm border">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-md text-sm bg-indigo-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
