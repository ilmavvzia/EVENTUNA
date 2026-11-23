<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Menampilkan daftar pengajuan event untuk ditinjau oleh Admin.
     */
    public function index(Request $request)
    {
        $query = Event::with(['user.fakultas', 'kategori', 'benefitSkp', 'approver']);

        // Filter status approval (pending, approved, rejected)
        if ($request->filled('status') && in_array($request->query('status'), ['pending', 'approved', 'rejected'])) {
            $query->where('status_approval', $request->query('status'));
        }

        // Pencarian berdasarkan judul event atau nama penyelenggara ormawa
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_event', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        // Hitung total status untuk badge tab filter
        $countPending  = Event::where('status_approval', 'pending')->count();
        $countApproved = Event::where('status_approval', 'approved')->count();
        $countRejected = Event::where('status_approval', 'rejected')->count();
        $countAll      = Event::count();

        return view('admin.approval.index', compact(
            'events',
            'countPending',
            'countApproved',
            'countRejected',
            'countAll'
        ));
    }

    /**
     * Menampilkan detail lengkap pengajuan event beserta berkas dan informasi ormawa.
     */
    public function show(string $id)
    {
        $event = Event::with(['user.fakultas', 'user.jenisOrmawa', 'kategori', 'benefitSkp', 'approver'])
            ->findOrFail($id);

        return view('admin.approval.show', compact('event'));
    }

    /**
     * Memproses persetujuan pengajuan event.
     */
    public function approve(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        // Cegah persetujuan ganda jika sudah berstatus approved
        if ($event->status_approval === 'approved') {
            return back()->with('error', 'Event "' . $event->judul_event . '" sudah disetujui sebelumnya.');
        }

        // Tentukan ID admin pemroses (dari auth atau admin default)
        $adminId = auth()->id() ?? User::where('role', 'admin')->value('id');

        $event->update([
            'status_approval'   => 'approved',
            'status_publikasi'  => 'published', // Otomatis dipublikasikan ke katalog
            'approved_by'       => $adminId,
            'catatan_penolakan' => null,
            'waktu_keputusan'   => now(),
        ]);

        return redirect()
            ->route('admin.approval.index')
            ->with('success', 'Event "' . $event->judul_event . '" berhasil DISETUJUI dan resmi dipublikasikan ke portal EVENTUNA!');
    }

    /**
     * Memproses penolakan pengajuan event beserta alasan/catatan perbaikan.
     */
    public function reject(Request $request, string $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|min:5|max:1000',
        ], [
            'catatan_penolakan.required' => 'Wajib menyertakan alasan penolakan agar pengurus Ormawa dapat melakukan evaluasi.',
            'catatan_penolakan.min'      => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $event = Event::findOrFail($id);

        $adminId = auth()->id() ?? User::where('role', 'admin')->value('id');

        $event->update([
            'status_approval'   => 'rejected',
            'status_publikasi'  => 'draft', // Ditarik dari publikasi
            'approved_by'       => $adminId,
            'catatan_penolakan' => $request->catatan_penolakan,
            'waktu_keputusan'   => now(),
        ]);

        return redirect()
            ->route('admin.approval.index')
            ->with('success', 'Pengajuan event "' . $event->judul_event . '" telah DITOLAK. Alasan penolakan telah tersimpan.');
    }
}
