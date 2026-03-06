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
            'lokasi'         => 'required|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
            'alamat'         => 'required|string',
            'kategori'       => 'required|in:tps,lps',
            'isi_laporan'    => 'required|string',
            'foto_pengaduan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional, maks 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors'  => $validator->errors()
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
                'lokasi'         => $request->lokasi,
                'alamat'         => $request->alamat,
                'kategori'       => $request->kategori,
                'isi_laporan'    => $request->isi_laporan,
                'foto_pengaduan' => $imagePath, // Path gambar yang sudah diupload
                'status'         => 'pending', // Sesuai default di database
            ]);

            // 4. Return Berhasil
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan Berhasil Dikirim',
                'data'    => $pengaduan
            ], 201);

        } catch (\Exception $e) {
            // Jika ada error jaringan atau database
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
