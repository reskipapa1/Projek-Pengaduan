<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    //untuk menampilkan semua pengaduan di view
    public function index(Request $request)
    {
        // STEP A: Ambil Data
        $query = Pengaduan::with('user.profile')->latest();

        // Filter berdasarkan lokasi/kawasan jika ada
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        $pengaduans = $query->get();

        $lokasis = [
            'bukit_raya' => 'Bukit Raya',
            'bina_widya' => 'Bina Widya',
            'marpoyan_damai' => 'Marpoyan Damai',
            'senapelan' => 'Senapelan',
            'rumbai' => 'Rumbai'
        ];

        // STEP B: Kirim ke Layar (View)
        return view('pengaduan.index', compact('pengaduans', 'lokasis'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'penugasan.petugas', 'penugasan.progres', 'komentars.user']);
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function dashboard()
    {
        $totalPengaduan = Pengaduan::count();
        $hariIni = Pengaduan::whereDate('created_at', today())->count();
        $diproses = Pengaduan::where('status', Pengaduan::STATUS_DIPROSES)->count();
        $selesai = Pengaduan::where('status', Pengaduan::STATUS_SELESAI)->count();

        $pengaduanTerbaru = Pengaduan::latest()->take(5)->get();

        // Data untuk Grafik Kepala Bagian & Super Admin
        $chartDataBulanan = null;
        $chartDataMingguan = null;
        
        if (auth()->check() && in_array(auth()->user()->role, [\App\Models\User::ROLE_KEPALA_BAGIAN, \App\Models\User::ROLE_SUPER_ADMIN])) {
            // --- Data Bulanan (Tahun Ini) ---
            $pengaduanPerBulan = Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
                ->whereYear('created_at', date('Y'))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get()
                ->keyBy('bulan');

            $labelsBulanan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $dataBulanan = [];

            for ($i = 1; $i <= 12; $i++) {
                $dataBulanan[] = isset($pengaduanPerBulan[$i]) ? $pengaduanPerBulan[$i]->jumlah : 0;
            }

            $chartDataBulanan = [
                'labels' => $labelsBulanan,
                'data' => $dataBulanan,
            ];

            // --- Data Mingguan (Minggu Ini) ---
            \Carbon\Carbon::setLocale('id'); // Bahasa Indonesia
            $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
            $labelsMingguan = [];
            $dataMingguan = [];
            
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $labelsMingguan[] = $date->isoFormat('dddd'); // Senin, Selasa, dll
                $dataMingguan[] = Pengaduan::whereDate('created_at', $date->toDateString())->count();
            }
            
            $chartDataMingguan = [
                'labels' => $labelsMingguan,
                'data' => $dataMingguan,
            ];
        }

        return view('dashboard', compact(
            'totalPengaduan',
            'hariIni',
            'diproses',
            'selesai',
            'pengaduanTerbaru',
            'chartDataBulanan',
            'chartDataMingguan'
        ));
    }


    public function create()
    {
        // Langsung buka file resources/views/pengaduan/create.blade.php
        // Gak perlu bawa data apa-apa karena form-nya kan masih kosong.
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        // $request = Isinya semua data yang diketik user di form (judul, isi, foto, dll).

        // STEP A: Validasi (Satpam)
        // Cek dulu, kalau datanya gak sesuai aturan, tendang balik ke form.

        $validated = $request->validate([
            'alamat' => 'required|max:50',
            'isi_laporan' => 'required|min:7',
            'foto_pengaduan' => 'required|image|max:5000',
            'kategori' => 'required|tps',
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

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan.');
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

        // Sesuaikan status penugasan jika pengaduan selesai atau ditolak
        if ($request->status === Pengaduan::STATUS_SELESAI || $request->status === Pengaduan::STATUS_DITOLAK) {
            if ($pengaduan->penugasan) {
                $pengaduan->penugasan->update([
                    'status_penugasan' => $request->status
                ]);
            }
        }

        // Jika status diubah menjadi diproses (Diterima & Proses)
        // Cari admin_penanganan yang lokasinya sesuai dengan lokasi pengaduan
        if ($request->status === Pengaduan::STATUS_DIPROSES) {
            // Cek apakah sudah ada penugasan untuk pengaduan ini
            $exists = \App\Models\Penugasan::where('pengaduan_id', $pengaduan->id)->exists();

            if (!$exists) {
                // Cari admin_penanganan yang lokasinya sama dengan lokasi pengaduan
                $namaLokasi = ucwords(str_replace('_', ' ', $pengaduan->lokasi));
                $petugas = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN_PENANGANAN)
                    ->whereHas('profile', function ($q) use ($pengaduan) {
                        $q->where('lokasi', $pengaduan->lokasi);
                    })
                    ->first();

                if (!$petugas) {
                    // Batalkan perubahan status — kembalikan ke pending
                    $pengaduan->update(['status' => Pengaduan::STATUS_PENDING]);
                    return back()->with(
                        'error',
                        "Belum ada Admin Penanganan yang bertugas di daerah \"{$namaLokasi}\". " .
                        "Silakan tambahkan akun admin untuk daerah tersebut terlebih dahulu, kemudian ubah status kembali."
                    );
                }

                \App\Models\Penugasan::create([
                    'pengaduan_id' => $pengaduan->id,
                    'petugas_id' => $petugas->id,
                    'status_penugasan' => 'ditugaskan',
                ]);
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

    public function exportPdfGlobal()
    {
        $pengaduans = Pengaduan::with(['user'])->latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pengaduan.pdf_global', compact('pengaduans'));
        return $pdf->download('rekap-pengaduan-' . date('Ymd') . '.pdf');
    }

    public function exportExcel()
    {
        $pengaduans = Pengaduan::with('user')->get();
        return response()->streamDownload(function () use ($pengaduans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Pelapor', 'Kategori', 'Lokasi', 'Alamat', 'Status', 'Tanggal']);
            foreach ($pengaduans as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->user ? $p->user->name : 'Anonim',
                    strtoupper($p->kategori),
                    ucwords(str_replace('_', ' ', $p->lokasi)),
                    $p->alamat,
                    $p->status,
                    $p->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        }, 'rekap-pengaduan-' . date('Ymd') . '.csv');
    }
}
