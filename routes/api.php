<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PengaduanApiController;
use App\Http\Controllers\Api\PenugasanApiController;

    // Route Auth (Public)
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// Export PDF (Public)
Route::get('/pengaduan/{id}/export-pdf', [PengaduanApiController::class, 'exportPdf']);

    // (Rute POST /pengaduan telah dipindah ke dalam middleware auth)

Route::middleware('auth:sanctum')->group(function () {
    // Route Auth (Protected)
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/profile/update', [AuthApiController::class, 'updateProfile']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Route Pengaduan (Protected)
    Route::post('/pengaduan', [PengaduanApiController::class, 'store']);
    Route::get('/pengaduan/all', [PengaduanApiController::class, 'all']); // Untuk Kepala Bagian
    Route::get('/pengaduan', [PengaduanApiController::class, 'index']);
    Route::get('/pengaduan/{id}', [PengaduanApiController::class, 'show']);
    Route::post('/pengaduan/{id}/komentar', [PengaduanApiController::class, 'storeKomentar']);
    Route::put('/pengaduan/{id}/status', [PengaduanApiController::class, 'updateStatus']);

    // Route Penugasan (Admin Penanganan)
    Route::get('/penugasan', [PenugasanApiController::class, 'index']);
    Route::post('/penugasan/{id}/lapor', [PenugasanApiController::class, 'lapor']);
});
