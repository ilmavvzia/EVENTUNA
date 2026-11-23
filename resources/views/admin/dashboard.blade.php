@extends('layouts.app')

@section('title', 'Dashboard Super Admin - EVENTUNA')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col">

    <!-- Top Navigation Bar Admin -->
    <header class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-wide text-purple-300 hover:text-purple-200 transition">
                EVENTUNA
            </a>
            <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100 font-medium">Panel Super Admin Kemahasiswaan</span>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-white font-semibold underline underline-offset-8 decoration-purple-400">Dashboard</a>
            <a href="{{ route('admin.approval.index') }}" class="text-slate-300 hover:text-white transition flex items-center gap-1.5">
                Approval Event
                @if($pendingEvents > 0)
                    <span class="bg-rose-500 text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded-full">
                        {{ $pendingEvents }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.ormawa.index') }}" class="text-slate-300 hover:text-white transition">Manajemen Ormawa</a>
            <a href="{{ route('admin.master.index') }}" class="text-slate-300 hover:text-white transition">Data Master</a>
            <a href="{{ url('/') }}" target="_blank" class="text-purple-300 hover:text-purple-200 transition text-xs border border-purple-500/40 px-2.5 py-1 rounded-lg">
                Lihat Katalog &rarr;
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-[#1e1b4b] via-[#2e1065] to-[#3b0764] rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <span class="inline-block bg-purple-500/30 text-purple-200 text-xs font-semibold px-3 py-1 rounded-full border border-purple-400/30">
                    Sistem Manajemen Event & SKP Kemahasiswaan
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang, Administrator Kemahasiswaan! 👋
                </h1>
                <p class="text-purple-200 text-sm max-w-2xl leading-relaxed">
                    Pantau pengajuan kegiatan organisasi mahasiswa Universitas Airlangga, validasi berkas legalitas SK kepengurusan, dan setujui publikasi event kampus secara real-time.
                </p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-purple-600/20 rounded-full blur-2xl"></div>
        </div>

        <!-- 1. Statistik Ringkasan Database Real-Time -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-base font-bold text-slate-800 uppercase tracking-wider text-xs">
                    Ringkasan Statistik Sistem
                </h2>
                <span class="text-xs text-slate-500">Data real-time dari database</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Card 1: Ormawa Menunggu Verifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ormawa Pending</p>
                            <h3 class="text-3xl font-extrabold text-amber-600 mt-2">{{ $pendingOrmawa }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Total: {{ $totalOrmawa }} Ormawa</span>
                        <a href="{{ route('admin.ormawa.index', ['status' => 'pending']) }}" class="text-indigo-600 font-semibold hover:underline">Verifikasi &rarr;</a>
                    </div>
                </div>

                <!-- Card 2: Ormawa Terverifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ormawa Aktif</p>
                            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $verifiedOrmawa }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">{{ $rejectedOrmawa }} Akun ditolak</span>
                        <a href="{{ route('admin.ormawa.index') }}" class="text-indigo-600 font-semibold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Card 3: Event Menunggu Approval -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Approval Event</p>
                            <h3 class="text-3xl font-extrabold text-rose-600 mt-2">{{ $pendingEvents }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Perlu ditinjau</span>
                        <a href="{{ route('admin.approval.index', ['status' => 'pending']) }}" class="text-indigo-600 font-semibold hover:underline">Review &rarr;</a>
                    </div>
                </div>

                <!-- Card 4: Event Terpublikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Event Tayang</p>
                            <h3 class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $publishedEvents }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Dari {{ $totalEvents }} total event</span>
                        <a href="{{ route('admin.approval.index') }}" class="text-indigo-600 font-semibold hover:underline">Semua &rarr;</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- 2. Action Shortcuts -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('admin.approval.index') }}"
               class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-indigo-400 hover:shadow-md transition flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Review Approval Event</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Periksa dan putuskan pengajuan kegiatan Ormawa</p>
                </div>
            </a>

            <a href="{{ route('admin.ormawa.create') }}"
               class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-indigo-400 hover:shadow-md transition flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Tambah Ormawa Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun organisasi resmi kampus</p>
                </div>
            </a>

            <a href="{{ route('admin.master.index') }}"
               class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-indigo-400 hover:shadow-md transition flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Kelola Data Master</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Atur kategori event dan bobot poin SKP</p>
                </div>
            </a>
        </div>

        <!-- 3. Two-Column Data: Antrean Approval & Ormawa Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Kiri: Antrean Event Menunggu Persetujuan (Pending) -->
            <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Antrean Approval Event Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Event yang diajukan Ormawa dan menunggu keputusan</p>
                    </div>
                    <a href="{{ route('admin.approval.index', ['status' => 'pending']) }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                        Lihat Semua ({{ $pendingEvents }}) &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingQueue as $pEvent)
                        <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 transition flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold text-white" style="background-color: {{ $pEvent->kategori->warna_badge ?? '#6366f1' }}">
                                        {{ $pEvent->kategori->nama_kategori ?? 'Event' }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        {{ $pEvent->created_at ? $pEvent->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $pEvent->judul_event }}</h4>
                                <p class="text-xs text-slate-500">
                                    Diajukan oleh: <strong class="text-slate-700">{{ $pEvent->user->name ?? 'Ormawa' }}</strong>
                                    ({{ $pEvent->user->fakultas->kode_fakultas ?? 'UNAIR' }})
                                </p>
                            </div>
                            <a href="{{ route('admin.approval.show', $pEvent->id) }}"
                               class="shrink-0 px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition">
                                Tinjau &rarr;
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-400">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-semibold text-slate-600">Tidak ada event yang menunggu persetujuan.</p>
                            <p class="text-xs mt-0.5">Semua pengajuan kegiatan telah diproses oleh Admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kanan: Organisasi Mahasiswa Terbaru -->
            <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Ormawa Terdaftar</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar akun organisasi mahasiswa terbaru</p>
                    </div>
                    <a href="{{ route('admin.ormawa.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                        Lihat Semua ({{ $totalOrmawa }}) &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentOrmawas as $rOrmawa)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                @if($rOrmawa->logo_path)
                                    <img src="{{ asset('storage/' . $rOrmawa->logo_path) }}" alt="{{ $rOrmawa->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center shrink-0 text-xs">
                                        {{ strtoupper(substr($rOrmawa->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.ormawa.show', $rOrmawa->id) }}" class="font-bold text-slate-900 text-xs hover:text-indigo-600 transition block">
                                        {{ $rOrmawa->name }}
                                    </a>
                                    <span class="text-[11px] text-slate-500">
                                        {{ $rOrmawa->fakultas->kode_fakultas ?? 'UNAIR' }} &bull; {{ $rOrmawa->events_count }} Event
                                    </span>
                                </div>
                            </div>
                            <div>
                                @if($rOrmawa->status_akun === 'verified')
                                    <span class="text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full">
                                        Verified
                                    </span>
                                @elseif($rOrmawa->status_akun === 'pending')
                                    <span class="text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full">
                                        Pending
                                    </span>
                                @else
                                    <span class="text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded-full">
                                        Rejected
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            Belum ada akun Ormawa terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; 2026 EVENTUNA &mdash; Portal Informasi Kegiatan & Manajemen SKP Mahasiswa Universitas Airlangga.
    </footer>

</div>
@endsection
