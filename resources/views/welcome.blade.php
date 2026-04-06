<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengaduan KP</title>
    <!-- Panggil CSS Tailwind dari Vite -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 w-full min-h-screen">
    <section>
    <div class="flex flex-col w-full max-w px-6 bg-white  dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Logo -->
       <div class="flex items-center justify-between w-full px-6 py-4">
            <div>
                <x-application-logo />
            </div>
        <!-- Tombol Login / Register -->
        <div class="flex gap-4 items-center">
            @if (Route::has('login'))
               @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                    Masuk ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 bg-green-400 text-white rounded-full border border-green-400 hover:bg-white hover:text-green-400 transition">
                    Masuk Portal Admin
                </a>
                @endauth
            @endif
        </div>
        </div>
    </div>
    </section>
    <section class="container mt-10 flex flex-col w-full text-left px-6">
            <h1 class="text-5xl font-bold mb-4 text-green-500 animate-fadeIn">Selamat Datang di Sistem Pengaduan KP</h1>
            <p class="text-lg  text-gray-700 dark:text-gray-300 font-medium">Sampaikan pengaduanmu dengan mudah dan cepat!</p>
    </section>
   <section class="w-full py-16">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
        
        <!-- Gambar -->
        <div class="w-full lg:w-1/2">
            <img src="{{ asset('dlhk-OPD-23-62002.jpeg') }}" 
                 alt="Ilustrasi DLHK Kota Pekanbaru"
                 loading="lazy"
                 class="w-full h-auto rounded-2xl shadow-lg transition duration-500 hover:scale-105 hover:shadow-2xl">
        </div>

        <!-- Konten -->
        <div class="w-full lg:w-1/2 flex flex-col">
            <p class="text-gray-800 dark:text-gray-300 leading-relaxed text-justify">
                <span class="font-bold text-green-500 text-lg">
                    Dinas Lingkungan Hidup dan Kebersihan (DLHK)
                </span>
                adalah lembaga pemerintah daerah yang bertanggung jawab mengelola lingkungan hidup, sampah, limbah, serta pengawasan polusi. 
                Di Pekanbaru, DLHK fokus pada kebersihan kota, operasional TPS 3R, dan penegakan hukum terhadap pelanggar pembuangan sampah.
                Jabatan Kepala DLHK Kota Pekanbaru per Februari 2026 dipegang oleh Reza Aulia Putra.
            </p>

            <h5 class="font-semibold mt-6 mb-4 text-green-500 text-lg">
                Berikut detail mengenai DLHK, khususnya di Kota Pekanbaru:
            </h5>

            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-3 text-justify">
                <li><strong>Tugas Utama:</strong> Mengelola sampah, mengawasi kualitas lingkungan, pengelolaan limbah, serta Ruang Terbuka Hijau (RTH).</li>
                <li><strong>Strategi Pengelolaan Sampah:</strong> Sosialisasi jadwal pembuangan sampah, penambahan ritasi angkutan malam hari, dan aktivasi tim penegak hukum (Gangkum).</li>
                <li><strong>Sanksi:</strong> Denda Rp50.000 hingga Rp500.000 bagi pelanggar pembuangan sampah.</li>
                <li><strong>Kepemimpinan:</strong> Reza Aulia Putra dilantik sebagai Kepala DLHK Kota Pekanbaru pada 19 Februari 2026.</li>
                <li>
                    <strong>Website Resmi:</strong> 
                    <a href="https://dlhk-kotapekanbaru.org" target="_blank" rel="noopener noreferrer" class="text-green-600 underline hover:text-green-800">
                        dlhk-kotapekanbaru.org
                    </a>,
                    <a href="https://dlhkotapekanbaru.id" target="_blank" rel="noopener noreferrer" class="text-green-600 underline hover:text-green-800">
                        dlhkotapekanbaru.id
                    </a>,
                    <a href="https://dlhk.pekanbaru.go.id" target="_blank" rel="noopener noreferrer" class="text-green-600 underline hover:text-green-800">
                        dlhk.pekanbaru.go.id
                    </a>
                </li>
            </ul>
        </div>

    </div>
</section>

<!-- Bagian Komentar Publik -->
@php
    $komentars = \App\Models\Komentar::with('user')->latest()->get();
@endphp

<section id="ulasan" class="w-full py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8 text-emerald-600">Dinding Komentar & Ulasan Publik</h2>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow mb-8 font-bold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow mb-8 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Form Komentar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow p-6 sticky top-6">
                    <h3 class="text-xl font-bold mb-2 text-emerald-700 border-b pb-3">Tinggalkan Ulasan</h3>
                    <p class="text-gray-500 mb-6 text-sm">Sistem memvalidasi email Anda untuk memastikan ulasan berasal dari pengguna aplikasi resmi.</p>
                    
                    <form action="{{ route('komentar.public.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Email Akun App</label>
                            <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2" placeholder="contoh: pengguna@gmail.com">
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Komentar Penilaian</label>
                            <textarea name="isi_komentar" required rows="4" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 px-4 py-2" placeholder="Ceritakan kepuasan kinerja DLHK di daerah Anda..."></textarea>
                            @error('isi_komentar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg shadow w-full">
                            Kirim Ulasan Layanan
                        </button>
                    </form>
                </div>
            </div>

            <!-- List Komentar -->
            <div class="w-full lg:w-2/3">
                <div class="space-y-4">
                    @forelse($komentars as $k)
                        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-emerald-500">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold mr-4">
                                    {{ strtoupper(substr($k->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $k->user->name }}</h4>
                                </div>
                                <span class="text-xs text-gray-400 font-medium bg-gray-100 px-3 py-1 rounded-full">{{ $k->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 whitespace-pre-line text-[15px] leading-relaxed ml-14">{{ $k->isi_komentar }}</p>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-12 bg-white rounded-xl shadow border-2 border-dashed border-gray-200">
                            <span class="font-semibold text-lg">Belum ada ulasan warga yang masuk.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
    
    <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 590" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150"><defs><linearGradient id="gradient" x1="0%" y1="50%" x2="100%" y2="50%"><stop offset="5%" stop-color="#00d084"></stop><stop offset="95%" stop-color="#7bdcb5"></stop></linearGradient></defs><path d="M 0,600 L 0,150 C 73.34928229665073,122.88995215311004 146.69856459330146,95.7799043062201 246,82 C 345.30143540669854,68.2200956937799 470.555023923445,67.77033492822966 575,102 C 679.444976076555,136.22966507177034 763.0813397129187,205.13875598086122 858,224 C 952.9186602870813,242.86124401913878 1059.1196172248804,211.67464114832535 1158,191 C 1256.8803827751196,170.32535885167465 1348.44019138756,160.16267942583733 1440,150 L 1440,600 L 0,600 Z" stroke="none" stroke-width="0" fill="url(#gradient)" fill-opacity="0.53" class="transition-all duration-300 ease-in-out delay-150 path-0"></path><defs><linearGradient id="gradient" x1="0%" y1="50%" x2="100%" y2="50%"><stop offset="5%" stop-color="#00d084"></stop><stop offset="95%" stop-color="#7bdcb5"></stop></linearGradient></defs><path d="M 0,600 L 0,350 C 113.29186602870814,371.23444976076553 226.58373205741628,392.4688995215311 327,394 C 427.4162679425837,395.5311004784689 514.9569377990431,377.35885167464113 604,356 C 693.0430622009569,334.64114832535887 783.5885167464116,310.0956937799043 888,307 C 992.4114832535884,303.9043062200957 1110.6889952153108,322.25837320574163 1205,333 C 1299.3110047846892,343.74162679425837 1369.6555023923447,346.87081339712915 1440,350 L 1440,600 L 0,600 Z" stroke="none" stroke-width="0" fill="url(#gradient)" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-1"></path></svg>
    <div class="flex justify-center items-center w-full h-10 text-emerald-700 bg-white dark:bg-gray-800">
        <p>Rezki R.A @ 2026</p>
    </div>
</body>
</html>
