<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index(){
        $komentars = komentar::latest()->get();
        return view('komentar.index',compact('komentars'));
    }

    public function create(){
        return view('komentar.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'isi_komentar' => 'required|min:5',
        ]);

         $data = [
            'isi_komentar' => $validated['isi_komentar'],
            'user_id'      => Auth::id(),      // Ambil ID user yang sedang login
            'pengaduan_id' => $pengaduan_id,   // Ambil ID pengaduan dari URL
        ];

        komentar::create($data);
        
        return redirect()->route('komentar.index')->with('success','Komentar berhasil ditambahkan');
    }

}
