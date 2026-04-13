<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengaduan KP - DLHK Pekanbaru</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Panggil CSS Tailwind dari Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#10b981 1px, transparent 1px), radial-gradient(#10b981 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            background-attachment: fixed;
            opacity: 0.8;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800 w-full min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 rounded-xl">
                        <x-application-logo class="w-10 h-10" />
                    </div>
                    <span class="font-bold text-xl tracking-tight text-emerald-900">Pengaduan<span
                            class="text-emerald-500">Masyarakat</span></span>
                </div>

                <!-- If Auth -> Dashboard Button -->
                <div class="flex gap-4 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-full hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            Masuk ke Dashboard
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <!-- Decoration element -->
        <div class="absolute top-0 right-0 -m-32 blur-3xl opacity-30 pointer-events-none">
            <div class="w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter"></div>
        </div>
        <div class="absolute bottom-0 left-0 -m-32 blur-3xl opacity-30 pointer-events-none">
            <div class="w-96 h-96 bg-teal-400 rounded-full mix-blend-multiply filter"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center z-10">
            <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-8 animate-fade-in-up">
                Suara Anda Membangun <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Kota Lebih
                    Bersih</span>
            </h1>
            <p class="mt-6 text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-light">
                Sistem Pengaduan Publik Dinas Lingkungan Hidup dan Kebersihan (DLHK) Pekanbaru. Laporkan masalah
                persampahan di lingkungan Anda dengan mudah.
            </p>
            <div class="mt-10 flex justify-center gap-4">
                <a href="#tentang"
                    class="px-8 py-3.5 bg-white text-emerald-700 font-semibold rounded-full shadow-sm ring-1 ring-emerald-200 hover:bg-emerald-50 hover:shadow-md transition-all">
                    Pelajari Lanjut
                </a>
                <a href="#ulasan"
                    class="px-8 py-3.5 bg-slate-900 text-white font-semibold rounded-full hover:bg-slate-800 shadow-md transition-all">
                    Lihat Ulasan
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi DLHK Section -->
    <section id="tentang" class="w-full py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Image Container with offset styling -->
                <div class="relative group">
                    <div
                        class="absolute inset-0 bg-emerald-500 rounded-3xl rotate-3 scale-105 opacity-20 group-hover:rotate-6 transition-transform duration-500">
                    </div>
                    <img src="{{ asset('dlhk-OPD-23-62002.jpeg') }}" alt="Ilustrasi DLHK Kota Pekanbaru" loading="lazy"
                        class="relative w-full h-auto rounded-3xl shadow-xl transition duration-500 group-hover:-translate-y-2 object-cover">
                </div>

                <!-- Text Content -->
                <div class="flex flex-col">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium text-sm mb-6 w-max">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Profil Instansi
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-6 leading-tight">
                        Dinas Lingkungan Hidup dan Kebersihan Kota Pekanbaru
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-6">
                        Lembaga pemerintah daerah yang bertanggung jawab mengelola lingkungan hidup, persampahan, dan
                        pengawasan polusi. Fokus utama saat ini adalah operasi kebersihan TPS 3R dan penegakan hukum
                        tata tertib persampahan.
                    </p>

                    <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl md:grid md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <div class="text-emerald-600 font-bold text-lg mb-2">Tugas Utama</div>
                            <p class="text-sm text-slate-600">Mengelola sampah, mengawasi kualitas lingkungan,
                                pengelolaan limbah, RTH.</p>
                        </div>
                        <div class="mt-6 md:mt-0">
                            <div class="text-emerald-600 font-bold text-lg mb-2">Penegakan Sanksi</div>
                            <p class="text-sm text-slate-600">Denda Rp50.000 hingga Rp500.000 bagi pelanggar buang
                                sampah sembarangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Komentar Publik Section -->
    @php
        $komentars = \App\Models\Komentar::whereNotNull('pengaduan_id')->with(['user', 'pengaduan'])->latest()->take(5)->get();
    @endphp

    <section id="ulasan" class="w-full py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Ulasan Layanan Publik</h2>
                <p class="text-slate-600">Baca opini jujur warga Pekanbaru mengenai kinerja pelayanan lingkungan yang
                    kami jalankan bersama.</p>
            </div>

            @if(session('success'))
                <div
                    class="max-w-3xl mx-auto bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-sm mb-10 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div
                    class="max-w-3xl mx-auto bg-rose-50 border border-rose-200 text-rose-800 px-6 py-4 rounded-xl shadow-sm mb-10 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="flex flex-col gap-12 max-w-4xl mx-auto">
                <!-- List Komentar -->
                <div class="w-full">
                    <div class="grid gap-6">
                        @forelse($komentars as $k)
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition-shadow group">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-700 font-bold text-lg border border-emerald-200">
                                        {{ strtoupper(substr($k->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4
                                                class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                                {{ $k->user->name }}
                                            </h4>
                                            @if($k->pengaduan)
                                                <p class="text-xs text-emerald-600 font-medium mt-1">Pada Pengaduan:
                                                    {{ substr($k->pengaduan->isi_laporan, 0, 40) }}...
                                                </p>
                                            @endif
                                        </div>
                                        <span
                                            class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">{{ $k->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 text-[15px] leading-relaxed mt-3">{{ $k->isi_komentar }}</p>
                                </div>
                            </div>
                        @empty
                            <div
                                class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl shadow-sm border border-slate-100 border-dashed">
                                <div class="h-16 w-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-700">Belum ada ulasan</h3>
                                <p class="text-slate-500 mt-2">Jadilah yang pertama untuk meninggalkan jejak di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <svg width="100%" height="auto" viewBox="0 0 1440 250" xmlns="http://www.w3.org/2000/svg" class="block bg-slate-50">
        <path d="M 0,250 C 480,100 960,350 1440,250 L 1440,250 L 0,250 Z" fill="#059669" class="opacity-10"></path>
        <path d="M 0,250 C 720,150 720,300 1440,200 L 1440,250 L 0,250 Z" fill="#059669"></path>
    </svg>

    <!-- Footer -->
    <footer class="bg-[#059669] text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="mb-10 flex flex-col items-center">
                <h3 class="text-lg font-bold uppercase tracking-wider text-emerald-100 mb-4">Kontak</h3>
                <ul class="space-y-3 text-emerald-50">
                    <li class="flex justify-center items-center gap-2">
                        <span class="font-semibold opacity-80">No HP:</span> 
                        <span>081246723682</span>
                    </li>
                    <li class="flex justify-center items-center gap-2">
                        <span class="font-semibold opacity-80">Email:</span> 
                        <span>dlhkkotapekanbaru.id@gmail.com</span>
                    </li>
                    <li class="text-sm opacity-80 mt-2 max-w-md mx-auto leading-relaxed">
                        Jl. Datuk Setia Maharaja No.04 simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau 28125
                    </li>
                </ul>
            </div>
            <div
                class="border-t border-emerald-500/50 pt-8 mt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm font-medium text-emerald-100">© 2026 Rezki R.A. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="https://dlhkotapekanbaru.id"
                        class="text-emerald-100 hover:text-white transition-colors text-sm font-medium bg-emerald-800/50 px-4 py-2 rounded-full">Website
                        Resmi</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>