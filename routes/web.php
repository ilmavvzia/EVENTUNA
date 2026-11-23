<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
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
    // Data Master Terpadu
    Route::prefix('master-data')->name('master.')->group(function () {
        Route::get('/', [MasterDataController::class, 'index'])->name('index');
        Route::post('/paket', [MasterDataController::class, 'storePaket'])->name('paket.store');
        Route::delete('/paket/{id}', [MasterDataController::class, 'destroyPaket'])->name('paket.destroy');
    });
});
