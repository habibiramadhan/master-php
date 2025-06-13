<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    // Peralatan Routes
    Route::resource('peralatan', PeralatanController::class);
    
    // Pesanan Routes
    Route::resource('pesanan', PesananController::class);
    Route::patch('pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    
    // Pembayaran Routes
    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::patch('pembayaran/{pesanan}/verify', [PembayaranController::class, 'verify'])->name('pembayaran.verify');
    Route::patch('pembayaran/{pesanan}/reject', [PembayaranController::class, 'reject'])->name('pembayaran.reject');
    
    // Laporan Routes
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    
    // Pengaturan Routes
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::patch('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
});

require __DIR__.'/auth.php';
