@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" enctype="multipart/form-data" action="{{route('pengaduan.store')}}"
    class="flex items-center flex-col max-w-96 mx-auto p-4 my-10 bg-green-500 rounded-lg shadow-md">
    @csrf
    <div class="w-full mb-4">
        <label for="alamat" class="block text-white font-bold mb-2">alamat</label>
        <textarea name="alamat" id="alamat" placeholder="Tuliskan alamat lengkap Anda di sini..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
            required>

            </textarea>
    </div>


    <div class="w-full mb-4">
        <label for="isi_laporan" class="block text-white font-bold mb-2">Isi Laporan</label>
        <input type="text" name="isi_laporan" id="isi_laporan"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
            required>
    </div>

    <div class="w-full mb-4">
        <label for="kategori" class="block text-white font-bold mb-2">Kategori</label>
        <select name="kategori" class="w-full rounded">
            <option value="tps">TPS</option>
            <!-- <option value="lps">LPS</option> -->
        </select>
    </div>

    <div class="w-full mb-4">
        <label for="lokasi" class="block text-white font-bold mb-2">Lokasi</label>
        <select name="lokasi" class="w-full rounded">
            <option value="bina_widya">Bina Widya</option>
            <option value="bukit_raya">Bukit Raya</option>
            <option value="marpoyan_damai">Marpoyan Damai</option>
            <option value="rumbai">Rumbai</option>
            <option value="senapelan">Senapelan</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-white font-bold mb-2">Foto</label>
        <input type="file" name="foto_pengaduan" required>
    </div>

    <button type="submit" class="bg-white text-green-600 font-bold mt-10 px-4 py-2 rounded hover:bg-gray-100">
        Kirim Pengaduan
    </button>
</form>