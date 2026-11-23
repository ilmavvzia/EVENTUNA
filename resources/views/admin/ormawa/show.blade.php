@extends('layouts.app')

@section('title', 'Detail Organisasi - ' . $ormawa->name . ' - EVENTUNA')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col">

    <!-- Top Navigation Bar Admin -->
    <header class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.index') }}" class="text-xl font-bold tracking-wide text-purple-300 hover:text-purple-200 transition">
                EVENTUNA
            </a>
            <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100 font-medium">Panel Super Admin</span>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('admin.master.index') }}" class="text-slate-300 hover:text-white transition">Data Master</a>
            <a href="{{ route('admin.ormawa.index') }}" class="text-white font-semibold underline underline-offset-8 decoration-purple-400">Manajemen Ormawa</a>
            <a href="{{ url('/dashboard') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
        </div>
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Top Navigation & Action -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('admin.ormawa.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Direktori Ormawa
                </a>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-2">Detail Profil Organisasi</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.ormawa.edit', $ormawa->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Data Ormawa
                </a>
            </div>
        </div>

        <!-- Profil Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0">
                    @if($ormawa->logo_path)
                        <img src="{{ asset('storage/' . $ormawa->logo_path) }}"
                             alt="{{ $ormawa->name }}"
                             class="w-24 h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-sm">
                    @else
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-extrabold flex items-center justify-center text-3xl shadow-sm">
                            {{ strtoupper(substr($ormawa->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <!-- Info Utama -->
                <div class="flex-1 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold text-slate-900">{{ $ormawa->name }}</h2>
                        <!-- Status Badge -->
                        @if($ormawa->status_akun === 'verified')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Akun Terverifikasi
                            </span>
                        @elseif($ormawa->status_akun === 'pending')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Menunggu Verifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Akun Ditolak / Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $ormawa->email }}
                        </span>
                        <span>&bull;</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $ormawa->fakultas->nama_fakultas ?? 'Tingkat Universitas' }}
                        </span>
                        <span>&bull;</span>
                        <span class="bg-indigo-50 text-indigo-700 font-bold px-2 py-0.5 rounded text-xs">
                            {{ $ormawa->jenisOrmawa->nama_jenis ?? 'Umum' }}
                        </span>
                    </div>

                    <p class="text-sm text-slate-600 pt-2 leading-relaxed">
                        {{ $ormawa->deskripsi_singkat ?? 'Belum ada deskripsi profil yang ditambahkan untuk organisasi ini.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Berkas SK Kepengurusan & Informasi Akun -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Dokumen SK -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Surat Keputusan (SK) Kepengurusan
                </h3>
                
                @if($ormawa->sk_kepengurusan_path)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                DOC
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Berkas SK Kepengurusan</p>
                                <p class="text-xs text-slate-500">Tersedia di penyimpanan sistem</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $ormawa->sk_kepengurusan_path) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Buka Berkas
                        </a>
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-sm">
                        Belum ada dokumen SK kepengurusan yang diunggah.
                    </div>
                @endif
            </div>

            <!-- Ringkasan Sistem -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Metadata Akun
                </h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-slate-500">ID Pengguna</dt>
                        <dd class="font-bold text-slate-800">#{{ $ormawa->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Role Sistem</dt>
                        <dd class="font-bold text-slate-800 uppercase">{{ $ormawa->role }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Terdaftar Pada</dt>
                        <dd class="font-medium text-slate-800">{{ $ormawa->created_at ? $ormawa->created_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Pembaruan Terakhir</dt>
                        <dd class="font-medium text-slate-800">{{ $ormawa->updated_at ? $ormawa->updated_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                    </div>
                </dl>
            </div>

        </div>

        <!-- Riwayat Event Milik Ormawa -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Riwayat Pengajuan & Publikasi Event</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Total {{ $ormawa->events_count }} kegiatan diajukan oleh organisasi ini.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="py-3 px-4">Judul Event</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Bobot SKP</th>
                            <th class="py-3 px-4">Jadwal Pelaksanaan</th>
                            <th class="py-3 px-4 text-center">Status Publikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($ormawa->events as $event)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-semibold text-slate-900">
                                    {{ $event->judul_event }}
                                    <div class="text-xs font-normal text-slate-400 mt-0.5">
                                        Lokasi: {{ $event->lokasi_atau_platform }}
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold text-white" style="background-color: {{ $event->kategori->warna_badge ?? '#4f46e5' }}">
                                        {{ $event->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-700">
                                    {{ $event->benefitSkp->nama_benefit ?? '-' }} ({{ $event->benefitSkp->bobot_poin ?? 0 }} Poin)
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($event->status_publikasi === 'published')
                                        <span class="inline-block bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full text-xs border border-emerald-200">
                                            Published
                                        </span>
                                    @elseif($event->status_publikasi === 'draft')
                                        <span class="inline-block bg-slate-100 text-slate-700 font-semibold px-2.5 py-1 rounded-full text-xs">
                                            Draft
                                        </span>
                                    @else
                                        <span class="inline-block bg-rose-50 text-rose-700 font-semibold px-2.5 py-1 rounded-full text-xs border border-rose-200">
                                            Closed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-sm">
                                    Organisasi ini belum mengajukan atau mempublikasikan event apapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; 2026 EVENTUNA &mdash; Portal Informasi Kegiatan & Manajemen SKP Mahasiswa Universitas Airlangga.
    </footer>

</div>
@endsection
