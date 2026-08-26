<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adjust Stok') }} — {{ $stokBarang->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <p class="text-sm text-gray-600 mb-4">Stok saat ini: <span class="font-semibold">{{ $stokBarang->stok }}</span></p>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('stok-barang.adjust.store', $stokBarang) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tipe</label>
                        <select name="tipe" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="masuk" @selected(old('tipe') == 'masuk')>Stok Masuk (+)</option>
                            <option value="keluar" @selected(old('tipe') == 'keluar')>Stok Keluar (-)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jumlah</label>
                        <input type="number" min="1" name="jumlah" value="{{ old('jumlah') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Keterangan (opsional)</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="mis. restock dari supplier, barang rusak, dsb.">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('stok-barang.index') }}" class="px-4 py-2 rounded-md text-sm border">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-md text-sm bg-emerald-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
