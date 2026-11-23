<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterKategoriEvent;
use Illuminate\Http\Request;

class MasterKategoriController extends Controller
{
    /**
     * Menampilkan daftar Master Kategori Event dengan fitur pencarian ILIKE dan pagination 10 baris.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kategoris = MasterKategoriEvent::withCount('events')
            ->when($search, function ($query, $search) {
                // Pencarian case-insensitive menggunakan ILIKE pada PostgreSQL
                $query->where('nama_kategori', 'ILIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategoris', 'search'));
    }

    /**
     * Menampilkan form tambah data kategori event baru.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data kategori baru dengan validasi server-side unik.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:master_kategori_event,nama_kategori',
            'warna_badge'   => 'required|string|max:30',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah terdaftar di sistem.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'warna_badge.required'   => 'Warna badge wajib dipilih.',
        ]);

        MasterKategoriEvent::create($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori event baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori event beserta relasi event yang menggunakan kategori ini.
     */
    public function show(MasterKategoriEvent $kategori)
    {
        $kategori->load(['events.user']);

        return view('admin.kategori.show', compact('kategori'));
    }

    /**
     * Menampilkan form edit kategori event.
     */
    public function edit(MasterKategoriEvent $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori dengan validasi server-side mengecualikan ID saat ini.
     */
    public function update(Request $request, MasterKategoriEvent $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:master_kategori_event,nama_kategori,' . $kategori->id,
            'warna_badge'   => 'required|string|max:30',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah digunakan oleh kategori lain.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'warna_badge.required'   => 'Warna badge wajib dipilih.',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori event berhasil diperbarui.');
    }

    /**
     * Menghapus kategori event dengan pencegahan referensial (restrict) jika masih dipakai data Event.
     */
    public function destroy(MasterKategoriEvent $kategori)
    {
        if ($kategori->events()->exists()) {
            return back()->with('error', 'Gagal Menghapus: Kategori "' . $kategori->nama_kategori . '" masih digunakan oleh data pengajuan event.');
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori event berhasil dihapus dari sistem.');
    }
}
