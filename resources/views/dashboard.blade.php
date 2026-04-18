<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard Admin Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Greeting -->
            <div
                class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -m-8 opacity-20">
                    <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 22h20L12 2zm0 3.8l7.5 15H4.5L12 5.8z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold mb-2 relative z-10">
                    Halo, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-emerald-50 relative z-10 font-medium">Selamat datang kembali di pusat manajemen pengaduan
                    DLHK.</p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Card 1 -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-4 bg-indigo-100 text-indigo-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-500 mb-1">Total Pengaduan</h2>
                        <p class="text-3xl font-bold text-slate-800">{{ $totalPengaduan ?? 0 }}</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-4 bg-sky-100 text-sky-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-500 mb-1">Pengaduan Hari Ini</h2>
                        <p class="text-3xl font-bold text-slate-800">{{ $hariIni ?? 0 }}</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-4 bg-amber-100 text-amber-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-500 mb-1">Sedang Diproses</h2>
                        <p class="text-3xl font-bold text-slate-800">{{ $diproses ?? 0 }}</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-4 bg-emerald-100 text-emerald-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-500 mb-1">Selesai Ditangani</h2>
                        <p class="text-3xl font-bold text-slate-800">{{ $selesai ?? 0 }}</p>
                    </div>
                </div>
            </div>

            @if(isset($chartDataBulanan) && isset($chartDataMingguan))
                <!-- Grafik Statistik -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-10">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                        <h2 id="chartTitle" class="text-lg font-bold text-slate-800">Statistik Pengaduan (Bulanan)</h2>
                        <div class="flex space-x-2">
                            <button id="btnBulanan" class="px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow hover:bg-emerald-700 transition">Bulanan</button>
                            <button id="btnMingguan" class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Mingguan</button>
                        </div>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="pengaduanChart"></canvas>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const ctx = document.getElementById('pengaduanChart').getContext('2d');

                        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
                        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                        const dataBulanan = {
                            labels: {!! json_encode($chartDataBulanan['labels']) !!},
                            data: {!! json_encode($chartDataBulanan['data']) !!}
                        };

                        const dataMingguan = {
                            labels: {!! json_encode($chartDataMingguan['labels']) !!},
                            data: {!! json_encode($chartDataMingguan['data']) !!}
                        };

                        let pengaduanChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: dataBulanan.labels,
                                datasets: [{
                                    label: 'Jumlah Pengaduan',
                                    data: dataBulanan.data,
                                    borderColor: '#10b981',
                                    backgroundColor: gradient,
                                    borderWidth: 3,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: '#10b981',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                                        titleFont: { size: 13, family: 'sans-serif' },
                                        bodyFont: { size: 14, weight: 'bold', family: 'sans-serif' },
                                        padding: 10,
                                        cornerRadius: 8,
                                        displayColors: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1,
                                            font: { family: 'sans-serif', color: '#64748b' }
                                        },
                                        grid: {
                                            color: '#f1f5f9',
                                            drawBorder: false
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        ticks: {
                                            font: { family: 'sans-serif', color: '#64748b' }
                                        }
                                    }
                                }
                            }
                        });

                        // Logic Toggle
                        const btnBulanan = document.getElementById('btnBulanan');
                        const btnMingguan = document.getElementById('btnMingguan');
                        const chartTitle = document.getElementById('chartTitle');

                        btnBulanan.addEventListener('click', () => {
                            btnBulanan.className = "px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow hover:bg-emerald-700 transition";
                            btnMingguan.className = "px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition";
                            
                            chartTitle.textContent = "Statistik Pengaduan (Bulanan)";
                            
                            pengaduanChart.data.labels = dataBulanan.labels;
                            pengaduanChart.data.datasets[0].data = dataBulanan.data;
                            pengaduanChart.update();
                        });

                        btnMingguan.addEventListener('click', () => {
                            btnMingguan.className = "px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow hover:bg-emerald-700 transition";
                            btnBulanan.className = "px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition";
                            
                            chartTitle.textContent = "Statistik Pengaduan (Mingguan)";
                            
                            pengaduanChart.data.labels = dataMingguan.labels;
                            pengaduanChart.data.datasets[0].data = dataMingguan.data;
                            pengaduanChart.update();
                        });
                    });
                </script>
            @endif

            <!-- Pengaduan Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-800">Pengaduan Terbaru</h2>
                    <a href="{{ route('pengaduan.index') }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-sm">
                                <th class="py-4 px-6 font-semibold">Pelapor</th>
                                <th class="py-4 px-6 font-semibold">Kategori</th>
                                <th class="py-4 px-6 font-semibold">Status</th>
                                <th class="py-4 px-6 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($pengaduanTerbaru ?? [] as $item)
                                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-800">
                                        {{ $item->user?->profile->name ?? 'Anonim' }}</td>
                                    <td class="py-4 px-6 text-slate-600">
                                        <span
                                            class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold">{{ strtoupper($item->kategori ?? '-') }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="{{ $item->status_color ?? 'bg-gray-100' }} px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border bg-opacity-10">
                                            {{ $item->status ?? 'pending' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-500">
                                        {{ $item->created_at?->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500 italic">Belum ada pengaduan
                                        terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>