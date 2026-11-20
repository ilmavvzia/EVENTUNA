<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\MasterDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');

// Rute Pengelolaan Data Master (Anggota 1 - Super Admin)
Route::prefix('admin/master-data')->name('admin.master.')->group(function () {
    Route::get('/', [MasterDataController::class, 'index'])->name('index');

    // CRUD Kategori Event
    Route::post('/kategori', [MasterDataController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [MasterDataController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [MasterDataController::class, 'destroyKategori'])->name('kategori.destroy');

    // CRUD Benefit SKP
    Route::post('/benefit', [MasterDataController::class, 'storeBenefit'])->name('benefit.store');
    Route::put('/benefit/{id}', [MasterDataController::class, 'updateBenefit'])->name('benefit.update');
    Route::delete('/benefit/{id}', [MasterDataController::class, 'destroyBenefit'])->name('benefit.destroy');
});