<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(){
        $rekomendBarang = Barang::where('is_rekomendasi', 1)->get();
        return view('public.index', compact('rekomendBarang'));
    }

    public function katalog(Request $request)
    {
        $query = Barang::query();

        if ($request->has('search') && $request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->paginate(12);

        return view('public.katalog', compact('barangs'));
    }

    public function barang($id){
        $barang = Barang::findOrFail($id);
        return view('public.barangShow', compact('barang'));
    }


}
