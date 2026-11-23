<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama Super Admin Kemahasiswaan dengan statistik database real-time.
     */
    public function index()
    {
        // 1. Statistik Organisasi Mahasiswa
        $totalOrmawa     = User::where('role', 'ormawa')->count();
        $verifiedOrmawa  = User::where('role', 'ormawa')->where('status_akun', 'verified')->count();
        $pendingOrmawa   = User::where('role', 'ormawa')->where('status_akun', 'pending')->count();
        $rejectedOrmawa  = User::where('role', 'ormawa')->where('status_akun', 'rejected')->count();

        // 2. Statistik Pengajuan & Publikasi Event
        $totalEvents     = Event::count();
        $pendingEvents   = Event::where('status_approval', 'pending')->count();
        $approvedEvents  = Event::where('status_approval', 'approved')->count();
        $rejectedEvents  = Event::where('status_approval', 'rejected')->count();
        $publishedEvents = Event::where('status_publikasi', 'published')->where('status_approval', 'approved')->count();

        // 3. Antrean Event Menunggu Persetujuan (Pending)
        $pendingQueue = Event::with(['user.fakultas', 'kategori'])
            ->where('status_approval', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // 4. Riwayat Seluruh Pengajuan Event Terbaru
        $recentEvents = Event::with(['user.fakultas', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Ormawa Terbaru yang Terdaftar di Sistem
        $recentOrmawas = User::where('role', 'ormawa')
            ->with(['fakultas', 'jenisOrmawa'])
            ->withCount('events')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrmawa',
            'verifiedOrmawa',
            'pendingOrmawa',
            'rejectedOrmawa',
            'totalEvents',
            'pendingEvents',
            'approvedEvents',
            'rejectedEvents',
            'publishedEvents',
            'pendingQueue',
            'recentEvents',
            'recentOrmawas'
        ));
    }
}
