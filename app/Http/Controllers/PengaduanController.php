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

    }
