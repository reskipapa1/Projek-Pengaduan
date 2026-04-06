<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    //untuk menampilkan semua pengaduan di view
    public function index()
    {
        // STEP A: Ambil Data
    // Pengaduan::latest() -> Artinya urutkan dari yang paling baru dibuat.
    // ->get()             -> Eksekusi ambil datanya sekarang.
        $pengaduans = Pengaduan::latest()->get();

        // STEP B: Kirim ke Layar (View)
    // view('pengaduan.index') -> Buka file di resources/views/pengaduan/index.blade.php
    // compact('pengaduan')    -> Bawa variabel $pengaduan tadi ke sana biar bisa ditampilkan.

        return view('pengaduan.index', compact('pengaduans'));

        
    }

     public function dashboard()
{
    $totalPengaduan = Pengaduan::count();
    $hariIni = Pengaduan::whereDate('created_at', today())->count();
    $diproses = Pengaduan::where('status', Pengaduan::STATUS_DIPROSES)->count();
    $selesai = Pengaduan::where('status', Pengaduan::STATUS_SELESAI)->count();

    $pengaduanTerbaru = Pengaduan::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalPengaduan',
        'hariIni',
        'diproses',
        'selesai',
        'pengaduanTerbaru'
    ));
}
    

    public function create(){
        // Langsung buka file resources/views/pengaduan/create.blade.php
    // Gak perlu bawa data apa-apa karena form-nya kan masih kosong.
        return view('pengaduan.create');
    }

        public function store(Request $request)
        {
            // $request = Isinya semua data yang diketik user di form (judul, isi, foto, dll).

        // STEP A: Validasi (Satpam)
        // Cek dulu, kalau datanya gak sesuai aturan, tendang balik ke form.

            $validated = $request -> validate([
                'alamat' => 'required|max:50',
                'isi_laporan' => 'required|min:7',
                'foto_pengaduan' => 'required|image|max:5000',
                'kategori' => 'required|in:tps,lps',
                'lokasi' => 'required|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
                ]);
                
                // Pengaduan::create([
                //     'alamat' => $request->alamat,
                //     'isi_laporan' => $request->isi_laporan,
                //     'kategori' => $request->kategori,
                //     'lokasi' => $request->lokasi,
                //     'status' => 'pending',
                // ]);

                // 2. Tambahkan data lain yang bukan inputan user (status default)
        // array_merge menggabungkan data $validated dengan data tambahan kita
                
               // SIMPAN FILE FOTO
                $pathFoto = $request->file('foto_pengaduan')
                                    ->store('pengaduan', 'public');

                // GABUNG DATA + PATH FOTO
                $data = array_merge($validated, [
                    'foto_pengaduan' => $pathFoto,
                    'status' => 'pending',
                ]);

                Pengaduan::create($data);

                return redirect()->route('pengaduan.index')->with ('success', 'Pengaduan berhasil ditambahkan.');
        }

    // Fungsi untuk mengupdate status pengaduan (Hanya untuk Super Admin)
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        // Validasi bahwa status yang dikirim sesuai dengan konstanta yang ada
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Pengaduan::STATUS_PENDING,
                Pengaduan::STATUS_DIPROSES,
                Pengaduan::STATUS_MENUNGGU_VERIFIKASI,
                Pengaduan::STATUS_SELESAI,
                Pengaduan::STATUS_DITOLAK,
            ]),
        ]);

        // Ubah status dan simpan ke database
        $pengaduan->update([
            'status' => $request->status
        ]);

        // Jika status diubah menjadi diproses (Diterima & Proses)
        // Kita juga harus membuat Penugasan untuk admin_penanganan
        if ($request->status === Pengaduan::STATUS_DIPROSES) {
            // Cek apakah sudah ada penugasan untuk pengaduan ini
            $exists = \App\Models\Penugasan::where('pengaduan_id', $pengaduan->id)->exists();
            
            if (!$exists) {
                // Ambil satu petugas admin_penanganan (bisa diubah nanti jika butuh pilih manual)
                $petugas = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN_PENANGANAN)->first();
                
                if ($petugas) {
                    \App\Models\Penugasan::create([
                        'pengaduan_id' => $pengaduan->id,
                        'petugas_id' => $petugas->id,
                        'status_penugasan' => 'ditugaskan', // status penugasan awal
                    ]);
                }
            }
        }

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    public function exportPdf(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'penugasan.petugas', 'penugasan.progres']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pengaduan.pdf', compact('pengaduan'));
        
        return $pdf->download('laporan-pengaduan-' . $pengaduan->id . '-' . date('Ymd') . '.pdf');
    }
}
