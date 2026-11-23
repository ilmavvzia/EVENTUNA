@extends('layouts.app')

@section('title', 'Tinjau Pengajuan - ' . $event->judul_event . ' - EVENTUNA Admin')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col">

    <!-- Top Navigation Bar Admin -->
    <header class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-wide text-purple-300 hover:text-purple-200 transition">
                EVENTUNA
            </a>
            <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100 font-medium">Panel Super Admin</span>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
            <a href="{{ route('admin.approval.index') }}" class="text-white font-semibold underline underline-offset-8 decoration-purple-400">Approval Event</a>
            <a href="{{ route('admin.ormawa.index') }}" class="text-slate-300 hover:text-white transition">Manajemen Ormawa</a>
            <a href="{{ route('admin.master.index') }}" class="text-slate-300 hover:text-white transition">Data Master</a>
        </div>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Breadcrumb & Back -->
        <div>
            <a href="{{ route('admin.approval.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Antrean Approval
            </a>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mt-2">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tinjau Pengajuan Kegiatan Kampus</h1>
                <!-- Current status badge -->
                <div>
                    @if($event->status_approval === 'approved')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            DISETUJUI & TAYANG DI KATALOG
                        </span>
                    @elseif($event->status_approval === 'rejected')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                            <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                            PENGAJUAN DITOLAK
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                            STATUS: MENUNGGU KEPUTUSAN ADMIN
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Card Catatan Penolakan Jika Event Ditolak -->
        @if($event->status_approval === 'rejected' && $event->catatan_penolakan)
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5 space-y-2">
                <div class="flex items-center gap-2 text-rose-800 font-bold text-sm">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Alasan Penolakan Oleh Admin Kemahasiswaan:
                </div>
                <p class="text-rose-900 text-sm leading-relaxed pl-7">
                    "{{ $event->catatan_penolakan }}"
                </p>
                <div class="text-[11px] text-rose-700 pl-7 pt-1">
                    Diputuskan oleh: <strong>{{ $event->approver->name ?? 'Admin Kemahasiswaan' }}</strong> pada {{ $event->waktu_keputusan ? $event->waktu_keputusan->translatedFormat('d F Y H:i') : '-' }} WIB
                </div>
            </div>
        @endif

        <!-- Card Informasi Persetujuan Jika Event Disetujui -->
        @if($event->status_approval === 'approved')
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center justify-between text-xs text-emerald-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Event ini telah diverifikasi dan disetujui oleh <strong>{{ $event->approver->name ?? 'Admin Kemahasiswaan' }}</strong> pada {{ $event->waktu_keputusan ? $event->waktu_keputusan->translatedFormat('d F Y H:i') : '-' }} WIB</span>
                </div>
                <span class="font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">STATUS PUBLIKASI: PUBLISHED</span>
            </div>
        @endif

        <!-- Main Event Detail Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 p-6 sm:p-8">

                <!-- Sisi Kiri: Poster Event (Jika ada) -->
                <div class="md:col-span-4 space-y-4">
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100 aspect-[3/4] flex items-center justify-center shadow-inner relative">
                        @if($event->poster_path)
                            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->judul_event }}" class="w-full h-full object-cover">
                        @else
                            <div class="p-6 text-center text-slate-400 space-y-2">
                                <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs font-semibold">Tidak ada berkas poster</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tautan Pendaftaran -->
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs space-y-1">
                        <span class="font-semibold text-slate-500 block">Tautan Pendaftaran Peserta:</span>
                        <a href="{{ $event->link_pendaftaran }}" target="_blank" class="text-indigo-600 font-bold hover:underline truncate block">
                            {{ $event->link_pendaftaran }} &nearr;
                        </a>
                    </div>
                </div>

                <!-- Sisi Kanan: Metadata & Deskripsi Event -->
                <div class="md:col-span-8 space-y-6">

                    <!-- Badges Kategori & Benefit SKP -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm" style="background-color: {{ $event->kategori->warna_badge ?? '#6366f1' }}">
                            {{ $event->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                            🎓 {{ $event->benefitSkp->nama_benefit ?? 'Non-SKP' }} &mdash; <strong>{{ $event->benefitSkp->bobot_poin ?? 0 }} Poin</strong>
                        </span>
                    </div>

                    <!-- Judul Event -->
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 leading-snug">{{ $event->judul_event }}</h2>
                        <p class="text-xs text-slate-400 mt-1">Slug URL: <code class="bg-slate-100 px-1 py-0.5 rounded">{{ $event->slug }}</code></p>
                    </div>

                    <!-- Organisasi Penyelenggara -->
                    <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                        @if($event->user->logo_path)
                            <img src="{{ asset('storage/' . $event->user->logo_path) }}" alt="{{ $event->user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-sm">
                                {{ strtoupper(substr($event->user->name ?? 'O', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Penyelenggara Kegiatan:</span>
                            <span class="text-sm font-bold text-slate-900">{{ $event->user->name ?? 'Ormawa' }}</span>
                            <span class="text-xs text-slate-500">({{ $event->user->fakultas->nama_fakultas ?? 'Tingkat Universitas' }})</span>
                        </div>
                    </div>

                    <!-- Jadwal & Lokasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-400 block">Jadwal Pelaksanaan</span>
                            <span class="font-bold text-slate-800 mt-0.5 block">
                                📅 {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                                @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                    &mdash; {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-400 block">Lokasi / Platform</span>
                            <span class="font-bold text-slate-800 mt-0.5 block truncate">
                                📍 {{ $event->lokasi_atau_platform }}
                            </span>
                        </div>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Lengkap Kegiatan</h4>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                            {{ $event->deskripsi }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Decision Box: Form Setujui & Tolak -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Keputusan Administrator Kemahasiswaan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Tentukan persetujuan publikasi kegiatan mahasiswa ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                
                <!-- Action 1: Setujui Event -->
                <div class="p-5 rounded-2xl border-2 border-emerald-200 bg-emerald-50/50 flex flex-col justify-between space-y-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 text-emerald-800 font-bold text-base">
                            <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Setujui Pengajuan Event
                        </div>
                        <p class="text-xs text-emerald-700 leading-relaxed">
                            Event akan langsung berstatus <strong>Disetujui</strong> dan secara otomatis <strong>Dipublikasikan</strong> ke katalog event mahasiswa (Guest) di halaman depan EVENTUNA.
                        </p>
                    </div>

                    <form action="{{ route('admin.approval.approve', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan MEMPUBLIKASIKAN event ini?')">
                        @csrf
                        <button type="submit"
                                class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                            <span>&check;</span> Setujui & Publikasikan Event
                        </button>
                    </form>
                </div>

                <!-- Action 2: Tolak Event -->
                <div class="p-5 rounded-2xl border-2 border-rose-200 bg-rose-50/50 flex flex-col justify-between space-y-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 text-rose-800 font-bold text-base">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak Pengajuan Event
                        </div>
                        <p class="text-xs text-rose-700 leading-relaxed">
                            Berikan catatan atau alasan mengapa event ditolak agar pengurus Ormawa dapat memperbaiki pengajuan mereka.
                        </p>
                    </div>

                    <form action="{{ route('admin.approval.reject', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan event ini?')">
                        @csrf
                        <div class="mb-3">
                            <textarea name="catatan_penolakan"
                                      rows="2"
                                      placeholder="Tuliskan alasan penolakan atau berkas yang belum lengkap..."
                                      required
                                      class="w-full p-2.5 bg-white border border-rose-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('catatan_penolakan', $event->catatan_penolakan) }}</textarea>
                            @error('catatan_penolakan')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                            <span>&cross;</span> Tolak Pengajuan Event
                        </button>
                    </form>
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
