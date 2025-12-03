<?php

namespace App\Http\Controllers;

use App\Models\BestSell;
use App\Models\Barang;
use Illuminate\Http\Request;

class BestSellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $banyakBarang = Barang::all();
        return view('admin.best_seller.index', compact('banyakBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateRekomendasi(Request $request)
    {
        $barang = Barang::find($request->id);

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        $countRekom = Barang::where('is_rekomendasi', true)->count();

        if ($request->is_rekomendasi && $countRekom >= 3) {
            return response()->json(['error' => 'Maksimal 3 barang bisa direkomendasikan'], 400);
        }

        $barang->is_rekomendasi = $request->is_rekomendasi;
        $barang->save();

        return response()->json(['success' => true]);
    }

    public function updateBulkRekomendasi(Request $request)
    {
        $ids = $request->rekomendasi_ids ?? [];

        if (count($ids) > 3) {
            return response()->json(['error' => 'Maksimal 3 barang bisa direkomendasikan'], 400);
        }

        // Reset semua rekomendasi jadi false dulu
        Barang::where('is_rekomendasi', true)->update(['is_rekomendasi' => false]);

        // Set true untuk barang yang terpilih
        Barang::whereIn('id', $ids)->update(['is_rekomendasi' => true]);

        return response()->json(['success' => true]);
    }
}
