<x-app-layout>
    <div class="py-10">
        <div class="w-full px-10">

            <!-- Heading -->
            <h1 class="text-2xl font-bold mb-4">
                Dashboard Admin Pengaduan
            </h1>
            <!-- greeting -->
            <div class="text-gray-900 mb-4 p-5">
                    {{ __("halo..") }} {{ Auth::user()->name }}
                </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-sm text-gray-500">Total Pengaduan</h2>
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ $totalPengaduan ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-sm text-gray-500">Pengaduan Hari Ini</h2>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ $hariIni ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-sm text-gray-500">Sedang Diproses</h2>
                    <p class="text-3xl font-bold text-yellow-500">
                        {{ $diproses ?? 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-sm text-gray-500">Selesai</h2>
                    <p class="text-3xl font-bold text-green-600">
                        {{ $selesai ?? 0 }}
                    </p>
                </div>
            </div>

            <!-- Pengaduan Terbaru -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
                <h2 class="text-lg font-semibold mb-4">
                    Pengaduan Terbaru
                </h2>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Pelapor</th>
                            <th class="py-2">Kategori</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Tanggal</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($pengaduanTerbaru ?? [] as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">{{ $item->nama ?? '-' }}</td>
                        <td class="py-2">{{ strtoupper($item->kategori) ?? '-' }}</td>
                        <td class="py-2 font-semibold">
                            <span class="{{ $item->status_color }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="py-2">
                            {{ $item->created_at?->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>