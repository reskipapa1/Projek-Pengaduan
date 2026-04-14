<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [PengaduanController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/export/excel', [PengaduanController::class, 'exportExcel'])->name('pengaduan.exportExcel');
    Route::get('/pengaduan/export/pdf-global', [PengaduanController::class, 'exportPdfGlobal'])->name('pengaduan.exportPdfGlobal');
    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    Route::get('/pengaduan/{pengaduan}/export-pdf', [PengaduanController::class, 'exportPdf'])->name('pengaduan.exportPdf');

    // Admin Komentar
    Route::get('/admin/komentar', [\App\Http\Controllers\KomentarController::class, 'indexAdmin'])->name('komentar.admin');

    // Manajemen Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::delete('/pengguna/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    Route::patch('/pengguna/{user}/lokasi', [PenggunaController::class, 'updateLokasi'])->name('pengguna.updateLokasi');
});

require __DIR__ . '/auth.php';
