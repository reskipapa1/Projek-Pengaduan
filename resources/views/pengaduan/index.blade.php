<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaduan') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    

     <a href="{{ route('pengaduan.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded">
        + Buat Pengaduan
    </a>

    <table class="w-full mt-4 border">
        <thead>
            <tr>
                <th>Alamat</th>
                <th>Isi Laporan</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Foto Bukti</th>
                <th>Tanggal Pengaduan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @if(count($pengaduans) == 0)
                <tr>
                    <td colspan="8">Belum ada pengaduan</td>
                </tr>
            @else
                @foreach ($pengaduans as $item)
                    <tr>
                        <td>{{ $item->alamat }}</td>
                        <td>{{$item->isi_laporan}}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{$item->lokasi}}</td>
                        <td>{{$item->foto_bukti}}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <span class="{{ $item->status_color }} font-semibold uppercase text-xs">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="p-2">
                            <!-- Jika status pending, tampilkan tombol Terima dan Tolak -->
                            @if($item->status === \App\Models\Pengaduan::STATUS_PENDING)
                                <div class="flex flex-col gap-2 justify-center">
                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_DIPROSES }}">
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded">
                                            Terima & Proses
                                        </button>
                                    </form>

                                    <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_DITOLAK }}">
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded mb-1" onclick="return confirm('Yakin ingin menolak pengaduan ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                </div>

                            <!-- Jika status diproses, tampilkan tombol Selesaikan -->
                            @elseif($item->status === \App\Models\Pengaduan::STATUS_DIPROSES)
                                <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="flex justify-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_SELESAI }}">
                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1.5 rounded my-1">
                                        Selesaikan Paksa
                                    </button>
                                </form>
                            @elseif($item->status === \App\Models\Pengaduan::STATUS_MENUNGGU_VERIFIKASI)
                                <form action="{{ route('pengaduan.updateStatus', $item->id) }}" method="POST" class="flex justify-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ \App\Models\Pengaduan::STATUS_SELESAI }}">
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded my-1 font-bold shadow-md">
                                        🔍 Verifikasi & Selesaikan
                                    </button>
                                </form>

                            <!-- Jika status selesai atau ditolak, tidak ada tombol -->
                            @else
                                <span class="text-xs text-gray-400 italic block mb-1">Tidak ada aksi</span>
                            @endif
                            <a href="{{ route('pengaduan.exportPdf', $item->id) }}" target="_blank" class="block w-full bg-gray-700 hover:bg-gray-800 text-white text-xs px-3 py-1.5 rounded text-center my-1">
                                📥 Export PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>



    
</x-app-layout>

        


