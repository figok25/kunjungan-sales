<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('toko.update', $toko) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_toko') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat', $toko->alamat) }}</textarea>
                        @error('alamat') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">No. Telp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $toko->no_telp) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('no_telp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Sales Penanggung Jawab</label>
                        <select name="sales_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Belum ditentukan --</option>
                            @foreach ($salesList as $sales)
                                <option value="{{ $sales->id }}" @selected(old('sales_id', $toko->sales_id) == $sales->id)>
                                    {{ $sales->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sales_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('toko.index') }}" class="px-4 py-2 rounded-md text-sm border">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-md text-sm bg-indigo-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
