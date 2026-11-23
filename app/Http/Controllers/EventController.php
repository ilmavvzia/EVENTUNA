<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MasterBenefitSkp;
use App\Models\MasterKategoriEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Halaman Utama Publik: Katalog event terbuka untuk Guest (tanpa login).
     * Dilengkapi filter pencarian ILIKE dan filter kategori.
     */
    public function publicIndex(Request $request)
    {
        $search = $request->query('search');
        $kategoriId = $request->query('kategori');

        $events = Event::with(['user', 'kategori', 'benefitSkp', 'rundowns'])
            ->where('status_publikasi', 'published')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_event', 'ILIKE', "%{$search}%")
                      ->orWhere('lokasi_atau_platform', 'ILIKE', "%{$search}%");
                });
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })
            ->latest('tanggal_mulai')
            ->paginate(9)
            ->withQueryString();

        $kategoris = MasterKategoriEvent::orderBy('nama_kategori')->get();

        return view('welcome', compact('events', 'kategoris', 'search', 'kategoriId'));
    }

    /**
     * Halaman Detail Publik: Menampilkan deskripsi event dan susunan rundown acara (Detail T1).
     */
    public function publicShow(string $slug)
    {
        $event = Event::with(['user.fakultas', 'user.jenisOrmawa', 'kategori', 'benefitSkp', 'rundowns' => function ($q) {
            $q->orderBy('waktu_mulai');
        }])
            ->where('slug', $slug)
            ->where('status_publikasi', 'published')
            ->firstOrFail();

        return view('events.public-show', compact('event'));
    }

    /**
     * Daftar Event milik Ormawa yang sedang login (T1).
     */
    public function index()
    {
        $events = Event::with(['kategori', 'benefitSkp', 'rundowns'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Form Pengajuan Event Baru (Header - Detail Rundown).
     */
    public function create()
    {
        $kategoris = MasterKategoriEvent::orderBy('nama_kategori')->get();
        $benefits  = MasterBenefitSkp::orderBy('nama_benefit')->get();

        return view('events.create', compact('kategoris', 'benefits'));
    }

    /**
     * Menyimpan data Header (events) dan Detail (event_rundowns) secara ATOMIK menggunakan DB::transaction().
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_event'          => 'required|string|max:200',
            'kategori_id'          => 'required|exists:master_kategori_event,id',
            'benefit_skp_id'       => 'required|exists:master_benefit_skp,id',
            'deskripsi'            => 'required|string',
            'tanggal_mulai'        => 'required|date',
            'tanggal_selesai'      => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi_atau_platform' => 'required|string|max:200',
            'link_pendaftaran'     => 'required|url|max:255',
            'poster_path'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_publikasi'     => 'required|in:draft,published',

            // Multi-baris Detail Rundown Acara
            'rundowns'                     => 'required|array|min:1',
            'rundowns.*.waktu_mulai'       => 'required',
            'rundowns.*.waktu_selesai'     => 'required',
            'rundowns.*.nama_sesi'         => 'required|string|max:150',
            'rundowns.*.pemateri_atau_pic' => 'nullable|string|max:150',
        ], [
            'judul_event.required'              => 'Judul event wajib diisi.',
            'kategori_id.required'              => 'Kategori event wajib dipilih.',
            'kategori_id.exists'                => 'Kategori event tidak valid di database.',
            'benefit_skp_id.required'           => 'Benefit & bobot SKP wajib dipilih.',
            'benefit_skp_id.exists'             => 'Benefit SKP tidak valid di database.',
            'deskripsi.required'                => 'Deskripsi kegiatan wajib diisi.',
            'tanggal_mulai.required'            => 'Tanggal mulai kegiatan wajib diisi.',
            'tanggal_selesai.after_or_equal'    => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'lokasi_atau_platform.required'     => 'Lokasi atau platform kegiatan wajib diisi.',
            'link_pendaftaran.required'         => 'Tautan formulir pendaftaran wajib diisi.',
            'link_pendaftaran.url'              => 'Format tautan pendaftaran harus berupa URL yang valid.',
            'poster_path.image'                 => 'Berkas poster harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'poster_path.max'                   => 'Ukuran poster maksimal 2MB.',
            'rundowns.required'                 => 'Susunan rundown acara wajib ditambahkan minimal 1 sesi.',
            'rundowns.min'                      => 'Tambahkan minimal 1 sesi rundown kegiatan.',
            'rundowns.*.waktu_mulai.required'   => 'Waktu mulai sesi wajib diisi.',
            'rundowns.*.waktu_selesai.required' => 'Waktu selesai sesi wajib diisi.',
            'rundowns.*.nama_sesi.required'     => 'Nama sesi / agenda kegiatan wajib diisi.',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster_path')) {
            $posterPath = $request->file('poster_path')->store('poster-events', 'public');
        }

        // Penyimpanan Atomik Header-Detail menggunakan DB::transaction
        DB::transaction(function () use ($validated, $posterPath) {
            $slugDasar = Str::slug($validated['judul_event']);
            $slugUnik  = $slugDasar . '-' . Str::lower(Str::random(6));

            $event = Event::create([
                'user_id'              => Auth::id(),
                'kategori_id'          => $validated['kategori_id'],
                'benefit_skp_id'       => $validated['benefit_skp_id'],
                'judul_event'          => $validated['judul_event'],
                'slug'                 => $slugUnik,
                'deskripsi'            => $validated['deskripsi'],
                'tanggal_mulai'        => $validated['tanggal_mulai'],
                'tanggal_selesai'      => $validated['tanggal_selesai'] ?? $validated['tanggal_mulai'],
                'lokasi_atau_platform' => $validated['lokasi_atau_platform'],
                'link_pendaftaran'     => $validated['link_pendaftaran'],
                'poster_path'          => $posterPath,
                'status_publikasi'     => $validated['status_publikasi'],
            ]);

            foreach ($validated['rundowns'] as $sesi) {
                $event->rundowns()->create([
                    'waktu_mulai'       => $sesi['waktu_mulai'],
                    'waktu_selesai'     => $sesi['waktu_selesai'],
                    'nama_sesi'         => $sesi['nama_sesi'],
                    'pemateri_atau_pic' => $sesi['pemateri_atau_pic'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Pengajuan event baru beserta susunan rundown berhasil disimpan!');
    }
}
