@extends('layouts.app')

@section('title', $event->judul_event . ' - EVENTUNA')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-700 hover:underline">
            &larr; Kembali ke Katalog Event
        </a>
    </div>

    <!-- Header Event Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
            <!-- Poster -->
            <div class="md:col-span-5 bg-slate-100 flex items-center justify-center min-h-[280px]">
                @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->judul_event }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="p-8 text-center text-slate-400">
                        <span class="text-4xl block mb-2">🎯</span>
                        <span class="text-xs font-semibold">Poster Resmi Ormawa</span>
                    </div>
                @endif
            </div>

            <!-- Ringkasan Info Event -->
            <div class="md:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm"
                              style="background-color: {{ $event->kategori->warna_badge ?? '#4f46e5' }}">
                            {{ $event->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full">
                            +{{ $event->benefitSkp->bobot_poin ?? 0 }} Poin SKP
                        </span>
                        <span class="text-xs text-slate-400">
                            {{ $event->benefitSkp->nama_benefit ?? '' }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $event->judul_event }}
                    </h1>

                    <div class="pt-1 text-sm text-slate-600 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">🏛</span>
                            <span>Penyelenggara: <strong class="text-slate-800">{{ $event->user->name ?? 'Pengurus Ormawa' }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">📅</span>
                            <span>
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d F Y') }}
                                @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                    — {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d F Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">📍</span>
                            <span>Lokasi / Platform: <strong class="text-slate-800">{{ $event->lokasi_atau_platform }}</strong></span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                    <div class="text-xs text-slate-400">
                        Dipublikasikan secara resmi di EVENTUNA
                    </div>
                    <a href="{{ $event->link_pendaftaran }}" target="_blank"
                       class="px-6 py-2.5 bg-purple-700 hover:bg-purple-800 text-white text-sm font-bold rounded-xl shadow-md transition">
                        Daftar Kegiatan Sekarang ↗
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi Lengkap -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm mb-8 space-y-3">
        <h2 class="text-lg font-bold text-slate-900">Deskripsi Kegiatan</h2>
        <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $event->deskripsi }}
        </div>
    </div>

    <!-- DETAIL RUNDOWN ACARA (DETAIL T1) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Susunan Jadwal & Rundown Acara (Detail T1)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Rincian agenda kegiatan mulai dari pembukaan hingga penutupan.</p>
            </div>
            <span class="px-3 py-1 bg-purple-50 text-purple-700 text-xs font-bold rounded-full">
                {{ $event->rundowns->count() }} Sesi Acara
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="py-3 px-6 w-16">No</th>
                        <th class="py-3 px-6 w-44">Waktu (WIB)</th>
                        <th class="py-3 px-6">Agenda / Nama Sesi</th>
                        <th class="py-3 px-6">Pemateri / PIC</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($event->rundowns as $index => $rundown)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 text-slate-400 font-medium">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3.5 px-6 font-mono font-bold text-purple-900">
                                {{ substr($rundown->waktu_mulai, 0, 5) }} - {{ substr($rundown->waktu_selesai, 0, 5) }}
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-slate-800">
                                {{ $rundown->nama_sesi }}
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $rundown->pemateri_atau_pic ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 px-6 text-center text-slate-400 text-xs">
                                Susunan rundown belum dirilis oleh penyelenggara.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
