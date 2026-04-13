<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::with('profile')
            ->whereIn('role', [
                User::ROLE_ADMIN_PENANGANAN,
                User::ROLE_KEPALA_BAGIAN,
            ])
            ->latest()
            ->get();

        return view('pengguna.index', compact('pengguna'));
    }

    public function updateLokasi(Request $request, User $user)
    {
        $request->validate([
            'lokasi' => 'nullable|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
        ]);

        // Pastikan hanya admin_penanganan yang bisa diset lokasinya
        if ($user->role !== User::ROLE_ADMIN_PENANGANAN) {
            return back()->with('error', 'Daerah penugasan hanya berlaku untuk Admin Penanganan.');
        }

        if ($user->profile) {
            $user->profile->update(['lokasi' => $request->lokasi]);
        } else {
            Profile::create([
                'user_id' => $user->id,
                'lokasi'  => $request->lokasi,
                'name'    => '-',
                'Nik'     => '-',
            ]);
        }

        return back()->with('success', 'Daerah penugasan berhasil diperbarui.');
    }
}
