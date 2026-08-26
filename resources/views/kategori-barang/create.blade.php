<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('kategori-barang.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Kategori</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('kategori-barang.index') }}" class="px-4 py-2 rounded-md text-sm border">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-md text-sm bg-indigo-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
