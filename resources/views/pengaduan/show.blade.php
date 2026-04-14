<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan') }} #{{ $pengaduan->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-6">
                        <table class="table-auto w-full text-left">
                            <tbody>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Pelapor</th>
                                    <td class="px-4 py-2 font-semibold">{{ $pengaduan->user->profile->name ?? $pengaduan->user->email ?? 'Anonim' }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Tanggal Laporan</th>
                                    <td class="px-4 py-2">{{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Lokasi</th>
                                    <td class="px-4 py-2">{{ ucwords(str_replace('_', ' ', $pengaduan->lokasi)) }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Alamat Detail</th>
                                    <td class="px-4 py-2">{{ $pengaduan->alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Kategori</th>
                                    <td class="px-4 py-2">{{ strtoupper($pengaduan->kategori) }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Keterangan</th>
                                    <td class="px-4 py-2">{{ $pengaduan->isi_laporan }}</td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4">Status</th>
                                    <td class="px-4 py-2">
                                        <span class="{{ $pengaduan->status_color }} font-bold uppercase text-sm border rounded px-2 py-1">
                                            {{ $pengaduan->status }}
                                        </span>
                                    </td>
                                </tr>
                                @if($pengaduan->penugasan && $pengaduan->penugasan->petugas)
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 w-1/4 align-top">Admin Penanganan</th>
                                    <td class="px-4 py-2">
                                        <div class="font-semibold text-emerald-700">
                                            {{ $pengaduan->penugasan->petugas->profile->name ?? $pengaduan->penugasan->petugas->email }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1 flex gap-4">
                                            <span><strong>NIK:</strong> {{ $pengaduan->penugasan->petugas->profile->Nik ?? '-' }}</span>
                                            <span><strong>Telp:</strong> {{ $pengaduan->penugasan->petugas->profile->no_telp ?? '-' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th class="px-4 py-2 text-gray-600 top align-top">Foto Laporan</th>
                                    <td class="px-4 py-2">
                                        @if($pengaduan->foto_pengaduan)
                                            <a href="{{ asset('storage/' . $pengaduan->foto_pengaduan) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $pengaduan->foto_pengaduan) }}" alt="Foto Laporan" class="w-64 border p-1 rounded shadow-sm hover:opacity-80">
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-6 pt-4 border-t">
                        <h3 class="font-bold text-lg mb-4 text-blue-700 pb-2">Progres Penanganan</h3>
                        @if($pengaduan->penugasan && $pengaduan->penugasan->progres && $pengaduan->penugasan->progres->count() > 0)
                            <div class="flex flex-col gap-4">
                                @foreach($pengaduan->penugasan->progres as $pro)
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 flex flex-col md:flex-row gap-4">
                                        <div class="flex-1">
                                            <div class="font-bold text-sm text-blue-800">
                                                Dilaporkan oleh: {{ $pengaduan->penugasan->petugas->profile->name ?? 'Admin Penanganan' }}
                                            </div>
                                            <div class="mt-1 text-gray-800">{{ $pro->keterangan_progres }}</div>
                                            @if($pengaduan->penugasan->penugasan_selesai && $loop->last)
                                                <div class="mt-2 inline-block bg-green-100 text-green-800 text-xs px-2 py-1 space-x-1 rounded font-semibold border border-green-200">
                                                    Status Penugasan Selesai: {{ \Carbon\Carbon::parse($pengaduan->penugasan->penugasan_selesai)->format('d M Y H:i') }}
                                                </div>
                                            @endif
                                        </div>
                                        @if($pro->foto_bukti)
                                            <div class="w-24 h-24 shrink-0 rounded overflow-hidden border border-blue-200">
                                                <a href="{{ asset('storage/' . $pro->foto_bukti) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $pro->foto_bukti) }}" class="w-full h-full object-cover hover:opacity-80 transition" alt="Foto Bukti">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 italic bg-gray-50 p-4 rounded text-center border-dashed border-2">Belum ada progres penanganan untuk pengaduan ini.</div>
                        @endif
                    </div>

                    <div class="mb-6 pt-4 border-t">
                        <h3 class="font-bold text-lg mb-4 text-emerald-700 pb-2">Komentar Publik</h3>
                        @if($pengaduan->komentars && $pengaduan->komentars->count() > 0)
                            <div class="flex flex-col gap-4">
                                @foreach($pengaduan->komentars as $komentar)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <div class="font-bold text-sm text-teal-600">{{ strtoupper($komentar->user->profile->name ?? $komentar->user->email ?? 'User') }}</div>
                                        <div class="mt-1 text-gray-800">{{ $komentar->isi_komentar }}</div>
                                        <div class="mt-2 text-xs text-gray-400 font-semibold">{{ $komentar->created_at->format('d M Y H:i') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 italic bg-gray-50 p-4 rounded text-center border-dashed border-2">Belum ada komentar untuk pengaduan ini.</div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-between border-t pt-4">
                        <a href="{{ route('pengaduan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-semibold transition">
                            ⬅ Kembali
                        </a>
                        
                        @if(in_array(auth()->user()->role, [\App\Models\User::ROLE_KEPALA_BAGIAN, \App\Models\User::ROLE_SUPER_ADMIN]))
                            <a href="{{ route('pengaduan.exportPdf', $pengaduan->id) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                📥 Export PDF Laporan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
