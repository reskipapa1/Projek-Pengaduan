<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progres_Penugasan;

class ProgresPenugasanController extends Controller
{
    public function index()
    {
        $progresPenugasan = Progres_Penugasan::all();
        return view('progres_penugasan.index', compact('progresPenugasan'));
    }

    public function create()
    {
        return view('progres_penugasan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan_progres' => 'required|min:7',
            'foto_bukti' => 'required|image|max:2048',
            'penugasan_id' => 'required|integer|exists:penugasan,id',
        ]);

        Progres_Penugasan::create($validated);

        $uploadFoto = Cloudinary::upload($request->file('foto_bukti')->getRealPath(), [
            'folder' => 'progres_penugasan',
        ]);
        return redirect()->route('progres_penugasan.index')->with('success', 'Progres Penugasan created successfully.');
    }
}
