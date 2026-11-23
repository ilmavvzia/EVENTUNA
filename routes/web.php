<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\MasterKategoriController;

// HALAMAN UTAMA PUBLIK (Langsung menampilkan daftar event tanpa wajib login)
Route::get('/', [EventController::class, 'publicIndex'])->name('home');
Route::get('/event/{slug}', [EventController::class, 'publicShow'])->name('events.public.show');

// Rute Autentikasi & Profil Pendaftaran Ormawa
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register-ormawa', [LoginController::class, 'showRegister'])->name('register.ormawa');
Route::post('/register-ormawa', [LoginController::class, 'storeRegister'])->name('register.ormawa.store');

// Rute Khusus Ormawa (Wajib Login & Role: ormawa)
Route::middleware(['auth', 'role:ormawa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // T1: Transaksi Pengajuan / Posting Event Baru (Header-Detail)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});

// Rute Khusus Super Admin (Wajib Login & Role: admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // M1: Master Kategori Event (Resource Controller wajib UAS)
    Route::resource('kategori', MasterKategoriController::class);

    // Data Master Terpadu
    Route::prefix('master-data')->name('master.')->group(function () {
        Route::get('/', [MasterDataController::class, 'index'])->name('index');
        Route::post('/paket', [MasterDataController::class, 'storePaket'])->name('paket.store');
        Route::delete('/paket/{id}', [MasterDataController::class, 'destroyPaket'])->name('paket.destroy');
    });
});