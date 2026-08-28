<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('kunjungan.store') }}"
                      x-data="kunjunganForm({{ $stokBarangs->map(fn ($b) => ['id' => $b->id, 'nama' => $b->nama_barang, 'harga' => (float) $b->harga, 'stok' => $b->stok])->values()->toJson() }})">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Toko</label>
                            <select name="toko_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Toko --</option>
                                @foreach ($tokos as $toko)
                                    <option value="{{ $toko->id }}" @selected(old('toko_id') == $toko->id)>
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal & Waktu Kunjungan</label>
                            <input type="datetime-local" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', now()->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">Default waktu sekarang, bisa diubah kalau mencatat kunjungan yang sudah lewat.</p>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Catatan (opsional)</label>
                            <textarea name="catatan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="mis. survei toko baru, follow-up pembayaran, dsb.">{{ old('catatan') }}</textarea>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700">Barang Dibeli (opsional)</label>
                                <button type="button" @click="addItem()" class="text-sm text-indigo-600 hover:underline">+ Tambah Barang</button>
                            </div>

                            <template x-if="items.length === 0">
                                <p class="text-sm text-gray-400 italic">Belum ada barang ditambahkan. Kunjungan bisa disimpan tanpa transaksi.</p>
                            </template>

                            <div class="space-y-2">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex flex-col sm:flex-row gap-2 sm:items-start border border-gray-100 rounded-md p-2 sm:border-0 sm:p-0">
                                        <select :name="`items[${index}][stok_barang_id]`" x-model.number="item.stok_barang_id" class="flex-1 min-w-0 border-gray-300 rounded-md shadow-sm text-sm">
                                            <option value="">-- Pilih Barang --</option>
                                            <template x-for="barang in barangList" :key="barang.id">
                                                <option :value="barang.id" x-text="`${barang.nama} (stok ${barang.stok}, Rp ${barang.harga.toLocaleString('id-ID')})`"></option>
                                            </template>
                                        </select>
                                        <div class="flex gap-2 items-center">
                                            <input type="number" min="1" :name="`items[${index}][jumlah]`" x-model.number="item.jumlah" placeholder="Qty" class="w-20 sm:w-24 border-gray-300 rounded-md shadow-sm text-sm">
                                            <span class="text-sm text-gray-500 flex-1 sm:w-32" x-text="formatSubtotal(item)"></span>
                                            <button type="button" @click="removeItem(index)" class="text-red-600 text-sm shrink-0">Hapus</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="text-right mt-3 text-sm font-semibold" x-show="items.length > 0">
                                Total: <span x-text="formatTotal()"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-6">
                        <a href="{{ route('kunjungan.index') }}" class="px-4 py-2 rounded-md text-sm border">Batal</a>
                        <button type="submit" class="px-4 py-2 rounded-md text-sm bg-indigo-600 text-white">Simpan Kunjungan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function kunjunganForm(barangList) {
            return {
                barangList: barangList,
                items: [],
                addItem() {
                    this.items.push({ stok_barang_id: '', jumlah: 1 });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                findBarang(id) {
                    return this.barangList.find(b => b.id === id);
                },
                formatSubtotal(item) {
                    const barang = this.findBarang(item.stok_barang_id);
                    if (!barang || !item.jumlah) return '';
                    return 'Rp ' + (barang.harga * item.jumlah).toLocaleString('id-ID');
                },
                formatTotal() {
                    const total = this.items.reduce((sum, item) => {
                        const barang = this.findBarang(item.stok_barang_id);
                        return sum + (barang && item.jumlah ? barang.harga * item.jumlah : 0);
                    }, 0);
                    return 'Rp ' + total.toLocaleString('id-ID');
                },
            };
        }
    </script>
</x-app-layout>
