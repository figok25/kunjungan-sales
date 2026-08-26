<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('stok-barang.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_barang') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                        <select name="kategori_barang_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_barang_id') == $kategori->id)>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_barang_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        @if ($kategoris->isEmpty())
                            <p class="text-amber-600 text-sm mt-1">Belum ada Kategori Barang. Tambahkan kategori terlebih dahulu.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Stok Awal</label>
                        <input type="number" min="0" name="stok_awal" value="{{ old('stok_awal', 0) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('stok_awal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Harga</label>
                        <input type="number" min="0" step="0.01" name="harga" value="{{ old('harga') }}" class="w-full border-gray-300 rounded-md shadow-sm">
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
