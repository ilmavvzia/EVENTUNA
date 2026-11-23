<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OrmawaController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Halaman Muka / Beranda Publik Guest
Route::get('/', function () {
    $events = \App\Models\Event::with(['user.fakultas', 'kategori', 'benefitSkp'])
        ->where('status_publikasi', 'published')
        ->where('status_approval', 'approved')
        ->latest()
        ->paginate(9);

    $kategoris = \App\Models\MasterKategoriEvent::all();

    return view('welcome', compact('events', 'kategoris'));
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');

// Rute Dashboard Pengurus Ormawa
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

// Modul Tanggung Jawab Anggota 2 (Panel Super Admin Kemahasiswaan)
Route::prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Super Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. CRUD Data Ormawa & Quick Approval Akun
    Route::resource('ormawa', OrmawaController::class);
    Route::patch('ormawa/{id}/verify', [OrmawaController::class, 'verify'])->name('ormawa.verify');
    Route::patch('ormawa/{id}/reject', [OrmawaController::class, 'reject'])->name('ormawa.reject');

    // 3. Transaksi Approval Event
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::get('/approval/{id}', [ApprovalController::class, 'show'])->name('approval.show');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
});
