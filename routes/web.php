
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OrmawaController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MasterKategoriController;

// ==========================================
// HALAMAN PUBLIK / GUEST
// ==========================================

Route::get('/', [EventController::class, 'publicIndex'])
    ->name('home');

Route::get('/event/{slug}', [EventController::class, 'publicShow'])
    ->name('events.public.show');

// ==========================================
// AUTENTIKASI
// ==========================================

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register-ormawa', [LoginController::class, 'showRegister'])
    ->name('register.ormawa');

Route::post('/register-ormawa', [LoginController::class, 'storeRegister'])
    ->name('register.ormawa.store');

// ==========================================
// DASHBOARD DAN FITUR KHUSUS ORMAWA
// ==========================================

Route::middleware(['auth', 'role:ormawa'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::get('/events/create', [EventController::class, 'create'])
        ->name('events.create');

    Route::post('/events', [EventController::class, 'store'])
        ->name('events.store');
});

// ==========================================
// FITUR KHUSUS SUPER ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Super Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD Ormawa
        Route::resource('ormawa', OrmawaController::class);

        // Verifikasi akun Ormawa
        Route::patch('/ormawa/{id}/verify', [OrmawaController::class, 'verify'])
            ->name('ormawa.verify');

        Route::patch('/ormawa/{id}/reject', [OrmawaController::class, 'reject'])
            ->name('ormawa.reject');

        // Approval Event
        Route::get('/approval', [ApprovalController::class, 'index'])
            ->name('approval.index');

        Route::get('/approval/{id}', [ApprovalController::class, 'show'])
            ->name('approval.show');

        Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])
            ->name('approval.approve');

        Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])
            ->name('approval.reject');

        // Master Kategori Event
        Route::resource('kategori', MasterKategoriController::class);

        // Master Data
        Route::prefix('master-data')->name('master.')->group(function () {

            Route::get('/', [MasterDataController::class, 'index'])
                ->name('index');

            Route::post('/kategori', [MasterDataController::class, 'storeKategori'])
                ->name('kategori.store');

            Route::put('/kategori/{id}', [MasterDataController::class, 'updateKategori'])
                ->name('kategori.update');

            Route::delete('/kategori/{id}', [MasterDataController::class, 'destroyKategori'])
                ->name('kategori.destroy');

            Route::post('/benefit', [MasterDataController::class, 'storeBenefit'])
                ->name('benefit.store');

            Route::put('/benefit/{id}', [MasterDataController::class, 'updateBenefit'])
                ->name('benefit.update');

            Route::delete('/benefit/{id}', [MasterDataController::class, 'destroyBenefit'])
                ->name('benefit.destroy');

            Route::post('/paket', [MasterDataController::class, 'storePaket'])
                ->name('paket.store');

            Route::delete('/paket/{id}', [MasterDataController::class, 'destroyPaket'])
                ->name('paket.destroy');
        });
    });
