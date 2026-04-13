<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ulasan Layanan DLHK Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-600 rounded-2xl shadow-lg p-8 mb-8 text-white flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Sorotan Publik & Komentar</h1>
                <p class="mt-2 text-emerald-100">Suara Anda sangat berarti bagi peningkatan layanan kebersihan kami.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 font-bold shadow">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 font-bold shadow">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow">
                <ul class="list-disc pl-5 font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-emerald-700">Tinggalkan Jejak Anda</h2>
            <p class="text-gray-500 mb-6 text-sm">Hanya akun yang telah terdaftar di aplikasi Mobile DLHK yang dapat menambahkan komentar.</p>
            <form action="{{ route('komentar.public.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email yang Terdaftar</label>
                    <input type="email" name="email" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3" placeholder="contoh: warga@gmail.com">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Tanggapan & Ulasan (Minimal 5 karakter)</label>
                    <textarea name="isi_komentar" required rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3" placeholder="Ceritakan bagaimana tanggapan atau kepuasan Anda mengenai layanan DLHK..."></textarea>
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition w-full md:w-auto">Kirim Ulasan Publik</button>
            </form>
        </div>

        <h3 class="text-xl font-bold mb-4 text-gray-800">Dinding Komentar Warga</h3>
        <div class="space-y-4">
            @forelse($komentars as $k)
                <div class="bg-white rounded-xl shadow p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center mb-3">
                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-lg mr-3 shadow-sm">
                            {{ strtoupper(substr($k->user->profile->name ?? $k->user->email, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $k->user->profile->name ?? 'Pengguna' }}</h4>
                            <p class="text-xs text-gray-500">{{ $k->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 whitespace-pre-line text-md">{{ $k->isi_komentar }}</p>
                </div>
            @empty
                <div class="text-center text-gray-500 py-10 bg-white rounded-xl shadow font-semibold">Tembok ini masih bersih. Jadilah yang pertama memberikan suara Anda!</div>
            @endforelse
        </div>
    </div>
</body>
</html>
