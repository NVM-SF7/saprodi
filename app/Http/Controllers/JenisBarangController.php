<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;

class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBarang = JenisBarang::all();
        return view('admin.jenis_barang.index', compact('jenisBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis_barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string'
        ]);

        JenisBarang::create([
            'jenis' => $request->nama,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisBarang $jenisBarang)
    {
        return view('admin.jenis_barang.edit', compact('jenisBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jenisBarang->update([
            'jenis' => $request->nama,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisBarang $jenisBarang)
    {
        // $jenis = JenisBarang::find($id);
        // if ($jenis) {
        //     $jenis->delete();
        //     return redirect()->route('jenis.index')->with('success', 'Berhasil Dihapus');
        // }

        $jenisBarang->delete();
        return redirect()->route('jenis_barang.index')->with('success', 'Data berhasil Dihapus');
    }
}
