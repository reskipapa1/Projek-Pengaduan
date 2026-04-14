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
                'lokasi' => $request->lokasi,
                'name' => '-',
                'Nik' => '-',
            ]);
        }

        return back()->with('success', 'Daerah penugasan berhasil diperbarui.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:' . User::ROLE_ADMIN_PENANGANAN . ',' . User::ROLE_KEPALA_BAGIAN,
            'lokasi' => 'nullable|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
            'nik' => 'nullable|string|max:20',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'Nik' => $request->nik ?? '-',
            'no_telp' => $request->no_telp ?? '-',
            'lokasi' => $request->role === User::ROLE_ADMIN_PENANGANAN ? $request->lokasi : null,
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        if (in_array($user->role, [User::ROLE_ADMIN_PENANGANAN, User::ROLE_KEPALA_BAGIAN])) {
            $user->delete();
            return back()->with('success', 'Pengguna berhasil dihapus.');
        }

        return back()->with('error', 'Tidak dapat menghapus pengguna ini.');
    }
}
