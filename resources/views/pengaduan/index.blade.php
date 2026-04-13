<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Daftar Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl shadow-sm mb-6 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if(auth()->user()->role === \App\Models\User::ROLE_KEPALA_BAGIAN)
                <div class="mb-6 flex flex-wrap gap-3">
                    <a href="{{ route('pengaduan.exportPdfGlobal') }}" target="_blank" class="inline-flex items-center gap-2 bg-rose-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-rose-700 shadow-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Export PDF Rekapitulasi
                    </a>
                    <a href="{{ route('pengaduan.exportExcel') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-700 shadow-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Export Excel Rekapitulasi
                    </a>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                                <th class="py-4 px-6 font-semibold">TGL. PENGADUAN</th>
                                <th class="py-4 px-6 font-semibold">PELAPOR & LOKASI</th>
                                <th class="py-4 px-6 font-semibold">KATEGORI</th>
                                <th class="py-4 px-6 font-semibold">STATUS</th>
                                <th class="py-4 px-6 font-semibold text-center">AKSI</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-slate-100">
                            @if(count($pengaduans) == 0)
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500 italic">Belum ada data pengaduan untuk saat ini.</td>
                                </tr>
                            @else
                                @foreach ($pengaduans as $item)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <!-- Tanggal -->
                                        <td class="py-4 px-6 text-slate-600">
                                            <div class="font-medium text-slate-800">{{ $item->created_at->format('d M Y') }}</div>
                                            <div class="text-xs">{{ $item->created_at->format('H:i') }}</div>
                                        </td>
                                                                                <!-- Pelapor & Lokasi -->
                                        <td class="py-4 px-6 max-w-xs whitespace-normal">
                                            <div class="font-bold text-slate-800 mb-1">{{ $item->user->profile->name ?? $item->user->email ?? 'Anonim' }}</div>
                                            <div class="text-xs text-slate-500 flex items-start gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <span>{{ ucwords(str_replace('_', ' ', $item->lokasi)) }} — <span class="truncate block">{{ $item->alamat }}</span></span>
                                            </div>
                                        </td>

                                        <!-- Kategori -->
                                        <td class="py-4 px-6">
                                            <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-xs font-bold">{{ strtoupper($item->kategori) }}</span>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4 px-6">
                                            <span class="{{ $item->status_color }} px-3 py-1.5 rounded-md text-xs font-bold uppercase tracking-wider border">
                                                {{ $item->status }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="py-4 px-6 text-center align-middle">
                                            <div class="flex flex-col gap-2 justify-center items-center w-32 mx-auto">
                                                
                                                <!-- Status Action Buttons (only for specific statuses) -->
                                                @if($item->status === \App\Models\Pengaduan::STATUS_PENDING)
                                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_DIPROSES }}">
                                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition-colors">
                                                            Terima & Proses
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_DITOLAK }}">
                                                        <button type="submit" class="w-full bg-slate-100 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-semibold px-3 py-2 rounded-lg transition-colors border border-rose-200 hover:border-rose-600" onclick="return confirm('Yakin ingin menolak pengaduan ini?')">
                                                            Tolak
                                                        </button>
                                                    </form>

                                                @elseif($item->status === \App\Models\Pengaduan::STATUS_DIPROSES)
                                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_SELESAI }}">
                                                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition-colors">
                                                            Selesaikan
                                                        </button>
                                                    </form>

                                                @elseif($item->status === \App\Models\Pengaduan::STATUS_MENUNGGU_VERIFIKASI)
                                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_SELESAI }}">
                                                        <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition-colors">
                                                            🔍 Verifikasi
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <!-- Lihat Detail Button -->
                                                <a href="{{ route('pengaduan.show', $item->id) }}" class="inline-flex w-full justify-center items-center gap-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition-colors">
                                                    👁️ Lihat Detail
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
