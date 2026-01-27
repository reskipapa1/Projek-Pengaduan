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
        $pengaduan = Pengaduan::latest()->get();

        // STEP B: Kirim ke Layar (View)
    // view('pengaduan.index') -> Buka file di resources/views/pengaduan/index.blade.php
    // compact('pengaduan')    -> Bawa variabel $pengaduan tadi ke sana biar bisa ditampilkan.

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create(){
        // Langsung buka file resources/views/pengaduan/create.blade.php
    // Gak perlu bawa data apa-apa karena form-nya kan masih kosong.
        return view('pengaduan.create;');
    }

    public function store(Request $request)
    {
         // $request = Isinya semua data yang diketik user di form (judul, isi, foto, dll).

    // STEP A: Validasi (Satpam)
    // Cek dulu, kalau datanya gak sesuai aturan, tendang balik ke form.

        $request -> validate([
            'alamat' => 'required|max:50',
            'isi_laporan' => 'required|min:7',
            'kategori' => 'required|in:tps,lps',
            'lokasi' => 'required|in:bukit_raya,bina_widya,marpoyan_damai,senapelan,rumbai',
            ]);
            
            Pengaduan::create([
                'alamat' => $request->alamat,
                'isi_laporan' => $request->isi_laporan,
                'kategori' => $request->kategori,
                'lokasi' => $request->lokasi,
                'status' => 'pending',
            ]);

            return redirect()->route('pengaduan.index')->with ('success', 'Pengaduan berhasil ditambahkan.');
    }

}
