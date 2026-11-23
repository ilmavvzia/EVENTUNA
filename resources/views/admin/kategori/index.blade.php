@extends('layouts.app')

@section('title', 'Master Kategori Event (M1) - EVENTUNA Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                    Modul M1
                </span>
                <h1 class="text-2xl font-bold text-slate-800">Master Kategori Event</h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">Kelola jenis kategori kegiatan mahasiswa beserta konfigurasi warna label badge.</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-purple-700 text-white text-sm font-semibold rounded-xl hover:bg-purple-800 shadow-sm transition">
            <span>+</span>
            <span>Tambah Kategori Baru</span>
        </a>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if (session('success'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-emerald-600 font-bold">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-rose-600 font-bold">⚠</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Pencarian (ILIKE PostgreSQL) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.kategori.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Cari nama kategori event (contoh: Workshop, Seminar, Lomba)..."
                       class="w-full pl-4 pr-10 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 transition">
                    Cari
                </button>
                @if (!empty($search))
                    <a href="{{ route('admin.kategori.index') }}"
                       class="px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-200 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Master Kategori -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="py-3.5 px-5 w-16">No</th>
                        <th class="py-3.5 px-5">Nama Kategori</th>
                        <th class="py-3.5 px-5">Preview Warna Badge</th>
                        <th class="py-3.5 px-5 text-center">Event Terkait</th>
                        <th class="py-3.5 px-5 text-right w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kategoris as $index => $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-5 text-slate-500">
                                {{ $kategoris->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-5 font-semibold text-slate-800">
                                <a href="{{ route('admin.kategori.show', $item) }}" class="hover:text-purple-700">
                                    {{ $item->nama_kategori }}
                                </a>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold text-white shadow-sm"
                                      style="background-color: {{ $item->warna_badge }}">
                                    <span class="w-2 h-2 rounded-full bg-white/70"></span>
                                    {{ $item->nama_kategori }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono ml-2">({{ $item->warna_badge }})</span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg {{ $item->events_count > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $item->events_count }} Event
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right space-x-1.5">
                                <a href="{{ route('admin.kategori.show', $item) }}"
                                   class="inline-block px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition"
                                   title="Lihat Detail">
                                    Detail
                                </a>
                                <a href="{{ route('admin.kategori.edit', $item) }}"
                                   class="inline-block px-2.5 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition"
                                   title="Edit Kategori">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kategori.destroy', $item) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori event &quot;{{ $item->nama_kategori }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-2.5 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition"
                                            title="Hapus Kategori">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 px-5 text-center text-slate-400">
                                @if(!empty($search))
                                    Tidak ditemukan kategori dengan kata kunci "<strong>{{ $search }}</strong>".
                                    <div class="mt-2">
                                        <a href="{{ route('admin.kategori.index') }}" class="text-xs font-semibold text-purple-700 hover:underline">
                                            Tampilkan Semua Kategori
                                        </a>
                                    </div>
                                @else
                                    Belum ada data kategori event di database. Silakan klik tombol "Tambah Kategori Baru".
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="mt-5">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection
