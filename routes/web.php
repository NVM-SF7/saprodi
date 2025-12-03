<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserBarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BestSellController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');
Route::get('/katalog', [LandingPageController::class, 'katalog'])->name('katalog');
Route::get('/produk/{id}', [LandingPageController::class, 'barang'])->name('produk.show');

// Admin routes - hanya bisa diakses oleh admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jenis_barang', JenisBarangController::class);
    Route::resource('best_sell', BestSellController::class);
    Route::post('/barang/update-bulk-rekomendasi', [BestSellController::class, 'updateBulkRekomendasi']);
    Route::resource('satuan', SatuanController::class);
    Route::resource('barang', BarangController::class);
    Route::post('settings/telepon', [DashboardController::class, 'updateTelepon']);
});

// User routes - bisa diakses oleh semua user yang login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
