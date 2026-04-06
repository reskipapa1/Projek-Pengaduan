<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Penugasan;
use App\Models\Progres_Penugasan;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Validator;

class PenugasanApiController extends Controller
{
    /**
     * Get daftar penugasan untuk Admin Penanganan yang sedang login
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== \App\Models\User::ROLE_ADMIN_PENANGANAN) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $penugasans = Penugasan::with(['pengaduan', 'progres'])
            ->where('petugas_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Tugas Penanganan',
            'data' => $penugasans
        ], 200);
    }

    /**
     * Submit progress laporan (Keterangan & Foto)
     */
    public function lapor(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== \App\Models\User::ROLE_ADMIN_PENANGANAN) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $penugasan = Penugasan::where('id', $id)->where('petugas_id', $user->id)->first();

        if (!$penugasan) {
            return response()->json(['success' => false, 'message' => 'Penugasan tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'keterangan_progres' => 'required|string',
            'foto_bukti'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imagePath = null;
        if ($request->hasFile('foto_bukti')) {
            $imagePath = $request->file('foto_bukti')->store('progres', 'public');
        }

        $progres = Progres_Penugasan::create([
            'penugasan_id'       => $penugasan->id,
            'keterangan_progres' => $request->keterangan_progres,
            'foto_bukti'         => $imagePath,
        ]);

        // Update status Penugasan & Pengaduan ke Menunggu Verifikasi
        $penugasan->update(['status_penugasan' => \App\Models\Pengaduan::STATUS_MENUNGGU_VERIFIKASI]);
        if ($penugasan->pengaduan) {
            $penugasan->pengaduan->update(['status' => \App\Models\Pengaduan::STATUS_MENUNGGU_VERIFIKASI]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Laporan progres berhasil disimpan',
            'data' => $progres
        ], 201);
    }
}
