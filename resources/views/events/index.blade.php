@extends('layouts.app')

@section('title', 'Daftar Event Ormawa (T1) - EVENTUNA')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                    Transaksi T1
                </span>
                <h1 class="text-2xl font-bold text-slate-800">Daftar Event Ormawa Anda</h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">Riwayat pengajuan event kegiatan mahasiswa beserta susunan detail rundown.</p>
        </div>
        <a href="{{ route('events.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-purple-700 text-white text-sm font-semibold rounded-xl hover:bg-purple-800 shadow-sm transition">
            <span>+</span>
            <span>Ajukan Event Baru (T1)</span>
        </a>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if (session('success'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2">
            <span class="text-emerald-600 font-bold">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center gap-2">
            <span class="text-rose-600 font-bold">⚠</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="py-3.5 px-5">Judul & Lokasi Kegiatan</th>
                        <th class="py-3.5 px-5">Kategori & Poin SKP</th>
                        <th class="py-3.5 px-5">Tanggal Pelaksanaan</th>
                        <th class="py-3.5 px-5 text-center">Detail Rundown</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $event->judul_event }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">📍 {{ $event->lokasi_atau_platform }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold text-white shadow-sm"
                                      style="background-color: {{ $event->kategori->warna_badge ?? '#4f46e5' }}">
                                    {{ $event->kategori->nama_kategori ?? '-' }}
                                </span>
                                <div class="text-xs text-indigo-700 font-bold mt-1">
                                    {{ $event->benefitSkp->nama_benefit ?? '-' }} (+{{ $event->benefitSkp->bobot_poin ?? 0 }} SKP)
                                </div>
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                <div class="font-medium text-slate-800">
                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                                </div>
                                @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                    <div class="text-xs text-slate-400">
                                        s.d. {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-bold rounded-lg">
                                    <span>⏱</span>
                                    <span>{{ $event->rundowns->count() }} Sesi</span>
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $event->status_publikasi === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $event->status_publikasi === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right space-x-1.5">
                                <a href="{{ route('events.public.show', $event->slug) }}"
                                   class="inline-block px-3 py-1.5 text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg transition"
                                   target="_blank">
                                    Lihat Publik ↗
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="text-sm">Belum ada pengajuan event dari organisasi Anda.</div>
                                <div class="mt-2">
                                    <a href="{{ route('events.create') }}" class="text-xs font-semibold text-purple-700 hover:underline">
                                        + Mulai Buat Pengajuan Event Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $events->links() }}
    </div>
</div>
@endsection
