<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengaduanApiController extends Controller
{
    /**
     * Menyimpan data pengaduan baru dari Mobile (Flutter)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'lokasi' => 'required|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
            'alamat' => 'required|string',
            'kategori' => 'required|in:tps,lps',
            'isi_laporan' => 'required|string',
            'foto_pengaduan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional, maks 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Upload Gambar (Jika ada)
            $imagePath = null;
            if ($request->hasFile('foto_pengaduan')) {
                // Simpan gambar ke folder storage/app/public/pengaduan
                $imagePath = $request->file('foto_pengaduan')->store('pengaduan', 'public');
            }

            // 3. Simpan ke Database
            $pengaduan = Pengaduan::create([
                'user_id' => $request->user()->id,
                'lokasi' => $request->lokasi,
                'alamat' => $request->alamat,
                'kategori' => $request->kategori,
                'isi_laporan' => $request->isi_laporan,
                'foto_pengaduan' => $imagePath, // Path gambar yang sudah diupload
                'status' => 'pending', // Sesuai default di database
            ]);

            // 4. Return Berhasil
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan Berhasil Dikirim',
                'data' => $pengaduan
            ], 201);

        } catch (\Exception $e) {
            // Jika ada error jaringan atau database
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan List Pengaduan berdasarkan Role
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Pengaduan::with(['komentars.user:id,email', 'penugasan.progres', 'penugasan.petugas'])->latest();

        // Implementasi Role Filtering
        if ($user->role == \App\Models\User::ROLE_KONSUMEN) {
            // Jika request meminta 'type=me', tampilkan laporan miliknya saja
            if ($request->query('type') === 'me') {
                $query->where('user_id', $user->id);
            }
            // Jika tidak, tampilkan semua laporan 
        }

        $pengaduans = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Pengaduan',
            'data' => $pengaduans
        ], 200);
    }

    /**
     * Tampilkan Detail Pengaduan
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Pengaduan',
            'data' => $pengaduan
        ], 200);
    }

    /**
     * Update Status Pengaduan (Khusus Super Admin & Admin Penanganan)
     */
    public function updateStatus(Request $request, $id)
    {
        $user = $request->user();

        // Cek Role
        if (!in_array($user->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_ADMIN_PENANGANAN])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah status'
            ], 403);
        }

        $pengaduan = Pengaduan::find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Pengaduan::STATUS_PENDING,
                Pengaduan::STATUS_DIPROSES,
                Pengaduan::STATUS_SELESAI,
                Pengaduan::STATUS_DITOLAK,
            ]),
        ]);

        $pengaduan->update([
            'status' => $request->status
        ]);

        if ($request->status === Pengaduan::STATUS_SELESAI || $request->status === Pengaduan::STATUS_DITOLAK) {
            if ($pengaduan->penugasan) {
                $pengaduan->penugasan->update([
                    'status_penugasan' => $request->status
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pengaduan berhasil diperbarui',
            'data' => $pengaduan
        ], 200);
    }

    /**
     * Tampilkan Semua Pengaduan untuk Kepala Bagian
     */
    public function all(Request $request)
    {
        $user = $request->user();

        if ($user->role !== \App\Models\User::ROLE_KEPALA_BAGIAN && $user->role !== \App\Models\User::ROLE_SUPER_ADMIN) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $pengaduans = Pengaduan::with(['user', 'penugasan.progres', 'penugasan.petugas', 'komentars.user:id,email'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Semua Data Pengaduan',
            'data' => $pengaduans
        ], 200);
    }

    /**
     * Download PDF untuk Laporan (Diakses via Mobile Browser URL)
     */
    public function exportPdf($id)
    {
        $pengaduan = Pengaduan::with(['user', 'penugasan.petugas', 'penugasan.progres'])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pengaduan.pdf', compact('pengaduan'));

        return $pdf->download('laporan-pengaduan-' . $pengaduan->id . '-' . date('Ymd') . '.pdf');
    }

    /**
     * Tambah Komentar ke Pengaduan (Hanya Pelapor)
     */
    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|string|max:1000'
        ]);

        $pengaduan = Pengaduan::find($id);

        if (!$pengaduan) {
            return response()->json(['success' => false, 'message' => 'Pengaduan tidak ditemukan'], 404);
        }

        // Cek apakah user adalah pembuat pengaduan
        if ($pengaduan->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Hanya pelapor yang dapat berkomentar pada pengaduan ini'], 403);
        }

        $komentar = $pengaduan->komentars()->create([
            'user_id' => $request->user()->id,
            'isi_komentar' => $request->isi_komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $komentar->load('user:id,name,email')
        ], 201);
    }
}
