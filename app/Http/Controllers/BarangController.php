<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banyakBarang = Barang::all();
        $rekomendBarang = Barang::where('is_rekomendasi', 1)->get();
        return view('admin.barang.index', compact('banyakBarang', 'rekomendBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banyakSatuan = Satuan::all();
        $banyakJenis = JenisBarang::all();
        return view('admin.barang.create', compact('banyakSatuan','banyakJenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "foto" => "nullable|image|max:11000",
            "nama" => "required|string|max:255",
            "detail" => "required|string",
            "harga" => "required|numeric",
            "id_jenis" => "nullable|integer|exists:jenis_barang,id",
            "id_satuan" => "nullable|integer|exists:satuan,id"
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')){
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        $data = [
            'foto' => $fotoPath,
            'nama' => $request->nama,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'id_jenis' => $request->id_jenis,
            'id_satuan' => $request->id_satuan
        ];

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return ('viws not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $banyakSatuan = Satuan::all();
        $banyakJenis = JenisBarang::all();
        return view('admin.barang.edit', compact('barang','banyakSatuan','banyakJenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255',
            'detail' => 'required|string',
            'harga' => 'required|numeric',
            'id_jenis' => 'nullable|exists:jenis_barang,id',
            'id_satuan' => 'nullable|exists:satuan,id',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($barang->id);

        // Logika penghapusan gambar lama sebelum menyimpan yang baru
        if ($request->hasFile('foto')) {
            if ($barang->foto && Storage::exists($barang->foto)) {
                Storage::delete($barang->foto); // Hapus gambar lama dari storage
            }
            $barang->foto = $request->file('foto')->store('barang', 'public'); // Simpan gambar baru
        }

        // Update data barang
        $barang->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'id_jenis' => $request->id_jenis,
            'id_satuan' => $request->id_satuan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success' , 'Data berhasil dihapus!');
    }
}
