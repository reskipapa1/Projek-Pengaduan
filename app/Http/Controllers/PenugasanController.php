<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penugasan;

class PenugasanController extends Controller
{
    public function index()
    {
        $penugasans = Penugasan::all();
        return view('penugasan.index', compact('penugasans'));
    }

    public function create()
    {
        return view('penugasan.create');
    }   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengaduan_id' => 'required|integer|exists:pengaduan,id',
            'petugas_id' => 'required|integer|exists:users,id',
        ]);

        $data = array_merge($validated, [
            'status_penugasan' => 'ditugaskan',
        ]);

        Penugasan::create($data);

        return redirect()->route('penugasan.index')->with('success', 'Penugasan created successfully.');
    }
}
