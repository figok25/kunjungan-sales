<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-ink leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-sm text-ink-muted mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-teal p-5">
                <p class="text-xs font-medium text-ink-muted uppercase tracking-wide">Kunjungan Bulan Ini</p>
                <p class="mt-2 text-3xl font-mono font-semibold text-ink">{{ number_format($kunjunganBulanIni) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-amber p-5">
                <p class="text-xs font-medium text-ink-muted uppercase tracking-wide">Penjualan Bulan Ini</p>
                <p class="mt-2 text-3xl font-mono font-semibold text-ink">Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-ink p-5">
                <p class="text-xs font-medium text-ink-muted uppercase tracking-wide">{{ auth()->user()->isSales() ? 'Toko Binaan' : 'Total Toko' }}</p>
                <p class="mt-2 text-3xl font-mono font-semibold text-ink">{{ number_format($totalToko) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border-t-4 {{ $stokMenipis > 0 ? 'border-red-500' : 'border-teal' }} p-5">
                <p class="text-xs font-medium text-ink-muted uppercase tracking-wide">Barang Stok Menipis</p>
                <p class="mt-2 text-3xl font-mono font-semibold {{ $stokMenipis > 0 ? 'text-red-600' : 'text-ink' }}">{{ number_format($stokMenipis) }}</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-5">
                <p class="text-sm font-medium text-ink mb-4">Penjualan 14 Hari Terakhir</p>
                <canvas id="chartPenjualan" height="90"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-5">
                <p class="text-sm font-medium text-ink mb-4">Penjualan per Kategori (Bulan Ini)</p>
                @if (count($chartKategori['labels']) > 0)
                    <canvas id="chartKategori" height="220"></canvas>
                @else
                    <p class="text-sm text-ink-muted text-center py-10">Belum ada data penjualan bulan ini.</p>
                @endif
            </div>
        </div>

        <!-- Recent Kunjungan -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-medium text-ink">Kunjungan Terbaru</p>
                <a href="{{ route('kunjungan.index') }}" class="text-sm text-teal hover:underline">Lihat semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-medium text-ink-muted">Tanggal</th>
                        <th class="px-5 py-3 text-left font-medium text-ink-muted">Toko</th>
                        <th class="px-5 py-3 text-left font-medium text-ink-muted">Sales</th>
                        <th class="px-5 py-3 text-right font-medium text-ink-muted">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($kunjunganTerbaru as $kunjungan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">{{ $kunjungan->tanggal_kunjungan->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('kunjungan.show', $kunjungan) }}" class="text-teal hover:underline">
                                    {{ $kunjungan->toko->nama_toko ?? '-' }}
                                </a>
                            </td>
                            <td class="px-5 py-3">{{ $kunjungan->sales->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-right font-mono">Rp {{ number_format($kunjungan->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-ink-muted">Belum ada kunjungan tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <script>
        const penjualanData = @json($chartPenjualan);
        new Chart(document.getElementById('chartPenjualan'), {
            type: 'line',
            data: {
                labels: penjualanData.labels,
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: penjualanData.data,
                    borderColor: '#0E7C61',
                    backgroundColor: 'rgba(14, 124, 97, 0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 2,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { callback: (v) => 'Rp ' + v.toLocaleString('id-ID') } }
                }
            }
        });

        @if (count($chartKategori['labels']) > 0)
        const kategoriData = @json($chartKategori);
        new Chart(document.getElementById('chartKategori'), {
            type: 'doughnut',
            data: {
                labels: kategoriData.labels,
                datasets: [{
                    data: kategoriData.data,
                    backgroundColor: ['#0E7C61', '#E8A33D', '#12203B', '#64748B', '#5FA88E', '#F0C77A'],
                    borderWidth: 0,
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
            }
        });
        @endif
    </script>
</x-app-layout>
