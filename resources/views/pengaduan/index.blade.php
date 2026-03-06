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
            <th>Alamat</th>
            <th>Isi Laporan</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Foto Bukti</th>
            <th>Tanggal Pengaduan</th>
            <th>Status</th>
        </thead>

        <tbody class="text-center">
            @forelse($pengaduans as $item)
                <tr>
                    <td>{{ $item->alamat }}</td>
                    <td>{{$item->isi_laporan}}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{$item->lokasi}}</td>
                    <td>{{$item->foto_bukti}}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada pengaduan</td>
                </tr>
            @endforelse
        </tbody>
    </table>



    
</x-app-layout>

        


