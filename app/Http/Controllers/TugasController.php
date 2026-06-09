<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class TugasController extends Controller
{
    // Tampilkan semua tugas
    public function index()
{
    $query = Tugas::orderBy('id', 'desc');

    if (request('filter') == 'aktif') {
        $query->where('selesai', 0);
    } elseif (request('filter') == 'selesai') {
        $query->where('selesai', 1);
    }

    $tugas = $query->get();
    return view('tugas.index', compact('tugas'));
}

    // Tampilkan form tambah
    public function create()
    {
        return view('tugas.create');
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
        ]);

        Tugas::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal'   => $request->tanggal,
            'selesai'   => false,
        ]);

        return redirect()->route('tugas.index');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('tugas.edit', compact('tugas'));
    }

    // Update tugas
    // Update tugas
    public function update(Request $request, $id)
{
        $request->validate([
            'judul' => 'required',
        ]);

        $tugas = Tugas::findOrFail($id);
        $tugas->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal'   => $request->tanggal ?: null,
            'selesai'   => $request->input('selesai', 0),
        ]);

    return redirect()->route('tugas.index');
}

    // Hapus tugas
    public function destroy($id)
    {
        Tugas::findOrFail($id)->delete();
        return redirect()->route('tugas.index');
    }
}