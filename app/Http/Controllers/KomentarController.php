<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KomentarController extends Controller
{
    // === AKSES PUBLIK ===
    public function indexPublic()
    {
        $komentars = \App\Models\Komentar::with('user.profile')->latest()->get();
        return view('komentar.public', compact('komentars'));
    }

    public function storePublic(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'isi_komentar' => 'required|min:5|max:1000',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan di sistem kami. Pastikan Anda telah terdaftar sebagai pengguna aplikasi.');
        }

        \App\Models\Komentar::create([
            'user_id' => $user->id,
            'isi_komentar' => $request->isi_komentar,
        ]);

        return redirect()->route('komentar.public')->with('success', 'Ulasan Anda berhasil dikirim!');
    }

    // === AKSES ADMIN ===
    public function indexAdmin()
    {
        $komentars = \App\Models\Komentar::with('user.profile')->latest()->get();
        return view('komentar.index', compact('komentars'));
    }
}
