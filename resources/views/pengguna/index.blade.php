<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- ===== SECTION: Admin Penanganan ===== --}}
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Admin Penanganan</h3>
                        <p class="text-sm text-slate-500">Atur daerah penugasan untuk setiap admin penanganan</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                                    <th class="py-4 px-6 font-semibold">NAMA</th>
                                    <th class="py-4 px-6 font-semibold">EMAIL</th>
                                    <th class="py-4 px-6 font-semibold">NIK</th>
                                    <th class="py-4 px-6 font-semibold">NO. TELP</th>
                                    <th class="py-4 px-6 font-semibold">DAERAH PENUGASAN</th>
                                    <th class="py-4 px-6 font-semibold text-center">UBAH DAERAH</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-100">
                                @forelse($pengguna->where('role', 'admin_penanganan') as $user)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-slate-800">{{ $user->profile->name ?? '-' }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600">{{ $user->email }}</td>
                                        <td class="py-4 px-6 text-slate-500 text-xs font-mono">{{ $user->profile->Nik ?? '-' }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $user->profile->no_telp ?? '-' }}</td>
                                        <td class="py-4 px-6">
                                            @if($user->profile?->lokasi)
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-3 py-1.5 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    {{ ucwords(str_replace('_', ' ', $user->profile->lokasi)) }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    Belum Ditentukan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            {{-- Tombol trigger modal --}}
                                            <button
                                                onclick="openModal({{ $user->id }}, '{{ $user->profile->name ?? $user->email }}', '{{ $user->profile?->lokasi ?? '' }}')"
                                                class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                Atur Daerah
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-slate-400 italic">Belum ada akun Admin Penanganan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== SECTION: Kepala Bagian ===== --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Kepala Bagian</h3>
                        <p class="text-sm text-slate-500">Daftar kepala bagian yang terdaftar</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                                    <th class="py-4 px-6 font-semibold">NAMA</th>
                                    <th class="py-4 px-6 font-semibold">EMAIL</th>
                                    <th class="py-4 px-6 font-semibold">NIK</th>
                                    <th class="py-4 px-6 font-semibold">NO. TELP</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-100">
                                @forelse($pengguna->where('role', 'kepala_bagian') as $user)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6 font-semibold text-slate-800">{{ $user->profile->name ?? '-' }}</td>
                                        <td class="py-4 px-6 text-slate-600">{{ $user->email }}</td>
                                        <td class="py-4 px-6 text-slate-500 text-xs font-mono">{{ $user->profile->Nik ?? '-' }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $user->profile->no_telp ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-slate-400 italic">Belum ada akun Kepala Bagian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MODAL: Atur Daerah Penugasan ===== --}}
    <div id="modal-lokasi" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <h3 class="text-lg font-bold text-white">Atur Daerah Penugasan</h3>
                <p id="modal-nama" class="text-blue-100 text-sm mt-1"></p>
            </div>
            <form id="form-lokasi" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="p-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Daerah Penugasan</label>
                    <select name="lokasi" id="select-lokasi" class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="">-- Belum Ditentukan --</option>
                        <option value="bukit_raya">Bukit Raya</option>
                        <option value="bina_widya">Bina Widya</option>
                        <option value="marpoyan_damai">Marpoyan Damai</option>
                        <option value="senapelan">Senapelan</option>
                        <option value="rumbai">Rumbai</option>
                    </select>
                    <p class="mt-3 text-xs text-slate-400">
                        Pengaduan dari daerah yang dipilih akan otomatis ditugaskan ke admin ini.
                    </p>
                </div>
                <div class="px-6 pb-6 flex gap-3 justify-end">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const lokasiBases = {
            'bukit_raya': '{{ route("pengguna.updateLokasi", "__id__") }}'.replace('__id__', ''),
        };

        function openModal(userId, nama, lokasiSaat) {
            const modal = document.getElementById('modal-lokasi');
            document.getElementById('modal-nama').textContent = nama;
            document.getElementById('form-lokasi').action = '/pengguna/' + userId + '/lokasi';
            document.getElementById('select-lokasi').value = lokasiSaat;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modal-lokasi');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal jika klik di luar
        document.getElementById('modal-lokasi').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

</x-app-layout>
