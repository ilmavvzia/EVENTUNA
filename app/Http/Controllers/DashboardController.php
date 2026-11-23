<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard Organisasi Mahasiswa dengan data dinamis dari database.
     */
    public function index()
    {
        // Jika pengguna yang login adalah Admin, arahkan ke Dashboard Admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Dapatkan akun Ormawa yang sedang login, atau fallback ke Ormawa pertama di database untuk preview
        $user = auth()->user() ?? User::where('role', 'ormawa')->with(['fakultas', 'jenisOrmawa'])->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Statistik event milik Ormawa yang bersangkutan
        $totalDiajukan   = $user->events()->count();
        $menungguPersetujuan = $user->events()->where('status_approval', 'pending')->count();
        $disetujui       = $user->events()->where('status_approval', 'approved')->count();
        $ditolak         = $user->events()->where('status_approval', 'rejected')->count();

        // Daftar event terbaru milik Ormawa ini
        $myEvents = $user->events()
            ->with(['kategori', 'benefitSkp'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'totalDiajukan',
            'menungguPersetujuan',
            'disetujui',
            'ditolak',
            'myEvents'
        ));
    }
}
