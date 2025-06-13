<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PublicController;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/peralatan', [PublicController::class, 'peralatan'])->name('peralatan.index');
Route::get('/peralatan/{id}', [PublicController::class, 'detailPeralatan'])->name('peralatan.detail');
Route::get('/booking', [PublicController::class, 'booking'])->name('booking.form');
Route::post('/booking', [PublicController::class, 'storeBooking'])->name('booking.store');
Route::get('/payment', [PublicController::class, 'payment'])->name('payment.form');
Route::post('/payment/upload', [PublicController::class, 'uploadPayment'])->name('payment.upload');
Route::get('/track', [PublicController::class, 'track'])->name('track.form');
Route::post('/track', [PublicController::class, 'checkTrack'])->name('track.check');
Route::get('/receipt/{tracking_id}', [PublicController::class, 'receipt'])->name('receipt.pdf');

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

    Route::get('/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}/approve', [AdminController::class, 'verifikasiApprove'])->name('verifikasi.approve');
    Route::post('/verifikasi/{id}/reject', [AdminController::class, 'verifikasiReject'])->name('verifikasi.reject');
    
    Route::resource('peralatan', PeralatanController::class);
    Route::resource('pesanan', PesananController::class);
    Route::patch('pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    
    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::patch('pembayaran/{pesanan}/verify', [PembayaranController::class, 'verify'])->name('pembayaran.verify');
    Route::patch('pembayaran/{pesanan}/reject', [PembayaranController::class, 'reject'])->name('pembayaran.reject');
    
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::patch('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::delete('/pengaturan/delete-logo', [PengaturanController::class, 'deleteLogo'])->name('pengaturan.delete-logo');
});

require __DIR__.'/auth.php';