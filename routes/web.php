<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PengaduanController::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'role:super_admin'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index')->middleware('role:super_admin');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create')->middleware('role:konsumen');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store')->middleware('role:konsumen');
    
});



require __DIR__.'/auth.php';
