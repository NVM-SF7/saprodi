<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Setting;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekomendBarang = Barang::where('is_rekomendasi', 1)->get();
        $banyakBarang = Barang::all();
        $setting = Setting::firstOrCreate(['key' => 'nomor_telepon'], ['value' => '']);
        return view('admin.index', compact('banyakBarang', 'rekomendBarang', 'setting'));
    }

    public function updateTelepon(Request $request)    {
        $request->validate(['value' => 'required|string']);
        Setting::updateOrCreate(['key' => 'nomor_telepon'], ['value' => $request->value]);
        return back()->with('success', 'Nomor telepon berhasil diperbarui.');
    }
}
