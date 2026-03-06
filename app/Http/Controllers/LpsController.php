<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lps;

class LpsController extends Controller
{
    public function index()
    {
        $lps = Lps::all();
        return view('lps.index', compact('lps'));
    }

    public function create()
    {
        return view('lps.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lps' => 'required|string|max:255',
            'wilayah_layanan' => 'required|string|max:255',
        ]);

        $data = array_merge($validated, [
            'status_operasional' => 'aktif',
        ]);

        lps::create($data);


        return redirect()->route('lps.index')->with('success', 'LPS created successfully.');

    }
}
