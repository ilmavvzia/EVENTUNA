@extends('layouts.app')

@section('title', 'Daftar Event Ormawa - EVENTUNA')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Event Ormawa Anda</h1>
            <p class="text-sm text-slate-500">Riwayat pengajuan event beserta jumlah sesi rundown yang terdaftar.</p>
        </div>
        <a href="{{ route('events.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-purple-700 text-white text-sm font-semibold rounded-xl hover:bg-purple-800 transition">
            + Ajukan Event Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                <tr>
                    <th class="py-3.5 px-5">Judul Event</th>
                    <th class="py-3.5 px-5">Kategori & SKP</th>
                    <th class="py-3.5 px-5">Tanggal</th>
                    <th class="py-3.5 px-5 text-center">Sesi Rundown</th>
                    <th class="py-3.5 px-5 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($events as $event)
                    <tr class="hover:bg-slate-50/70">
                        <td class="py-3.5 px-5">
                            <div class="font-bold text-slate-800">{{ $event->judul_event }}</div>
                            <div class="text-xs text-slate-500">{{ $event->lokasi_atau_platform }}</div>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold text-white"
                                  style="background-color: {{ $event->kategori->warna_badge ?? '#4f46e5' }}">
                                {{ $event->kategori->nama_kategori ?? '-' }}
                            </span>
                            <div class="text-xs text-indigo-700 font-semibold mt-1">
                                {{ $event->benefitSkp->nama_benefit ?? '-' }} ({{ $event->benefitSkp->bobot_poin ?? 0 }} SKP)
                            </div>
                        </td>
                        <td class="py-3.5 px-5 text-slate-600">
                            {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                        </td>
                        <td class="py-3.5 px-5 text-center font-semibold text-slate-700">
                            {{ $event->rundowns->count() }} Sesi
                        </td>
                        <td class="py-3.5 px-5 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $event->status_publikasi === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ ucfirst($event->status_publikasi) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">
                            Belum ada event yang diajukan. Klik tombol "+ Ajukan Event Baru" di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection