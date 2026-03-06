<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::get('/user', function (Request $request) {
    return $request->request->user();
})->middleware('auth:sanctum');

// Rute untuk membuat Pengaduan dari Mobile
Route::post('/pengaduan', [App\Http\Controllers\Api\PengaduanApiController::class, 'store']);
