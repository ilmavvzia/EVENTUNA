@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $kategori->nama_kategori . ' - EVENTUNA Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-700 hover:underline mb-2">
                &larr; Kembali ke Daftar Kategori
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Detail Master Kategori Event (M1)</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kategori.edit', $kategori) }}"
               class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                Edit Kategori
            </a>
        </div>
    </div>

    <!-- Informasi Ringkas Kategori -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Nama Kategori</span>
                <span class="text-lg font-bold text-slate-800 mt-1 block">{{ $kategori->nama_kategori }}</span>
            </div>
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Badge & Hex Code</span>
                <div class="mt-1 flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm"
                          style="background-color: {{ $kategori->warna_badge }}">
                        {{ $kategori->nama_kategori }}
                    </span>
                    <span class="font-mono text-xs text-slate-500">({{ $kategori->warna_badge }})</span>
                </div>
            </div>
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Total Event Terdaftar</span>
                <span class="text-lg font-bold text-indigo-700 mt-1 block">{{ $kategori->events->count() }} Kegiatan</span>
            </div>
        </div>
    </div>

    <!-- Daftar Kegiatan yang Terkait -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800">Daftar Event dengan Kategori Ini</h2>
            <span class="text-xs text-slate-500 font-medium">{{ $kategori->events->count() }} Data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="py-3 px-5">Judul Event</th>
                        <th class="py-3 px-5">Penyelenggara</th>
                        <th class="py-3 px-5">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kategori->events as $event)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3.5 px-5 font-semibold text-slate-800">
                                {{ $event->judul_event }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                {{ $event->user->name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $event->status_publikasi === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($event->status_publikasi) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 px-5 text-center text-slate-400 text-xs">
                                Belum ada event yang menggunakan kategori ini. Kategori ini aman untuk dihapus bila tidak diperlukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
