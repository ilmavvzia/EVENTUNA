@extends('layouts.app')

@section('title', 'Dashboard Organisasi - ' . ($user->name ?? 'EVENTUNA'))

@section('content')

<div class="min-h-screen flex bg-slate-50">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#1e2a44] text-white min-h-screen hidden md:flex flex-col">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-white/10">
            <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-wide text-white block">
                EVENTUNA
            </a>
            <p class="text-xs text-slate-400 mt-1">
                PORTAL KEGIATAN MAHASISWA
            </p>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2">

            <p class="text-xs text-slate-400 uppercase font-bold px-3 mb-3">
                Menu Utama
            </p>

            <a href="{{ url('/dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-semibold">
                <span>▦</span>
                <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ url('/') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-white/10 transition">
                <span>◈</span>
                <span class="text-sm">Katalog Event</span>
            </a>

            <p class="text-xs text-slate-400 uppercase font-bold px-3 pt-6 mb-3">
                Pintasan Sistem
            </p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-purple-300 hover:bg-purple-900/30 transition text-xs border border-purple-500/20">
                <span>⚙</span>
                <span>Panel Super Admin</span>
            </a>

        </nav>

        <!-- Sidebar Footer Profil -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                @if($user->logo_path)
                    <img src="{{ asset('storage/' . $user->logo_path) }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover border border-white/20">
                @else
                    <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white text-xs">
                        {{ strtoupper(substr($user->name ?? 'O', 0, 1)) }}
                    </div>
                @endif
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">{{ $user->name ?? 'Pengurus Ormawa' }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ $user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 min-w-0">

        <!-- NAVBAR -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Dashboard Pengurus Ormawa
                </h2>
                <p class="text-xs text-slate-500">
                    {{ $user->fakultas->nama_fakultas ?? 'Universitas Airlangga' }} &bull; {{ $user->jenisOrmawa->nama_jenis ?? 'Ormawa' }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Status Akun Badge -->
                @if($user->status_akun === 'verified')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        &check; Akun Terverifikasi
                    </span>
                @elseif($user->status_akun === 'pending')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                        ⏳ Menunggu Verifikasi Admin
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        &cross; Akun Nonaktif
                    </span>
                @endif
            </div>

        </header>

        <!-- CONTENT -->
        <section class="p-6 sm:p-8 space-y-6">

            <!-- Welcome Banner -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Selamat Datang, {{ $user->name }}! 👋
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola publikasi agenda kegiatan mahasiswa dan pantau proses persetujuan berkas event oleh Admin Kemahasiswaan.
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ url('/') }}" class="px-4 py-2 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                        Lihat Katalog Event
                    </a>
                </div>
            </div>

            <!-- Statistics Cards (Real Database Queries) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengajuan</p>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalDiajukan }}</h2>
                    <p class="text-xs text-indigo-600 mt-2">Seluruh kegiatan diajukan</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Approval</p>
                    <h2 class="text-3xl font-extrabold text-amber-600 mt-2">{{ $menungguPersetujuan }}</h2>
                    <p class="text-xs text-slate-400 mt-2">Sedang direview admin</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Disetujui & Tayang</p>
                    <h2 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $disetujui }}</h2>
                    <p class="text-xs text-slate-400 mt-2">Tampil di portal Guest</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ditolak / Revisi</p>
                    <h2 class="text-3xl font-extrabold text-rose-600 mt-2">{{ $ditolak }}</h2>
                    <p class="text-xs text-slate-400 mt-2">Perlu perbaikan berkas</p>
                </div>

            </div>

            <!-- Event Table (Real Data Ormawa yang Sedang Login) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="p-5 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">
                            Daftar Pengajuan Event Organisasi Anda
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Status persetujuan dan publikasi kegiatan kampus
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">Judul Kegiatan</th>
                                <th class="px-5 py-3.5">Tanggal Pelaksanaan</th>
                                <th class="px-5 py-3.5">Kategori & SKP</th>
                                <th class="px-5 py-3.5 text-center">Status Approval</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($myEvents as $ev)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-5 py-4 font-semibold text-slate-900">
                                        {{ $ev->judul_event }}
                                        <div class="text-xs font-normal text-slate-500 mt-0.5">
                                            📍 {{ $ev->lokasi_atau_platform }}
                                        </div>
                                        @if($ev->status_approval === 'rejected' && $ev->catatan_penolakan)
                                            <div class="mt-1.5 p-2 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-700">
                                                <strong>Catatan Admin:</strong> "{{ $ev->catatan_penolakan }}"
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-slate-600 text-xs">
                                        {{ \Carbon\Carbon::parse($ev->tanggal_mulai)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold text-white" style="background-color: {{ $ev->kategori->warna_badge ?? '#6366f1' }}">
                                            {{ $ev->kategori->nama_kategori ?? 'Kategori' }}
                                        </span>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            {{ $ev->benefitSkp->bobot_poin ?? 0 }} Poin SKP
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($ev->status_approval === 'approved')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Disetujui & Tayang
                                            </span>
                                        @elseif($ev->status_approval === 'rejected')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Menunggu Review
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-slate-400">
                                        Belum ada kegiatan yang diajukan oleh organisasi Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </section>

    </main>

</div>

@endsection
