@extends('layouts.app')

@section('title', 'EVENTUNA - Portal Event & Manajemen SKP Mahasiswa')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col font-sans">

    <!-- HERO & NAVBAR WRAPPER (Gradien Ungu Gelap) -->
    <div class="bg-gradient-to-b from-[#180a3a] via-[#1e1045] to-[#2a135f] text-white">

        <!-- NAVBAR -->
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-wrap justify-between items-center gap-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-wide text-white hover:text-purple-200 transition">
                    EVENTUNA
                </a>
                <span class="bg-purple-800/80 text-purple-200 text-xs px-3 py-1 rounded-full font-medium border border-purple-500/30">
                    Pengurus Ormawa
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm">
                <a href="{{ url('/') }}" class="text-white font-semibold">Beranda Event</a>
                <span class="text-white/30 hidden sm:inline">|</span>
                <a href="{{ url('/dashboard') }}" class="text-purple-200 hover:text-white transition">Dashboard Ormawa</a>
                <span class="text-white/30 hidden sm:inline">|</span>
                <a href="{{ route('admin.dashboard') }}" class="text-purple-300 hover:text-white transition text-xs border border-purple-400/30 px-2.5 py-1 rounded-lg">
                    Panel Admin &rarr;
                </a>
                <a href="{{ url('/login') }}" class="bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-md transition">
                    Masuk
                </a>
            </div>
        </nav>

        <!-- HERO SECTION -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Sisi Kiri: Judul & Keterangan -->
                <div class="lg:col-span-8 space-y-4">
                    <span class="inline-block bg-purple-900/60 text-purple-200 text-xs font-bold uppercase tracking-wider px-3.5 py-1 rounded-full border border-purple-500/40">
                        Portal Informasi Kegiatan & SKP Mahasiswa
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight">
                        Temukan Seminar, Lomba, & Pelatihan Kampus Terbaru
                    </h1>
                    <p class="text-purple-200 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Jelajahi berbagai event resmi dari BEM, HIMA, dan UKM tanpa perlu login. Pengurus Ormawa dapat mendaftarkan profil organisasinya untuk mempublikasikan event.
                    </p>
                </div>

                <!-- Sisi Kanan: Panel Profil Singkat Ormawa -->
                <div class="lg:col-span-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center space-y-4 shadow-xl">
                        <div class="space-y-1">
                            <p class="text-xs text-purple-300">Pusat Ormawa:</p>
                            <h3 class="font-bold text-white text-base">Portal Penyelenggara Kegiatan</h3>
                            <p class="text-xs text-purple-200">Universitas Airlangga</p>
                        </div>
                        <a href="{{ url('/login') }}"
                           class="block w-full py-3 px-4 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg transition">
                            + Posting Event Baru
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- MAIN BODY: FILTER & KATALOG EVENT -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 space-y-8 pb-16">

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-4">
            <form action="{{ url('/') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                
                <!-- Input Search -->
                <div class="sm:col-span-6 relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari judul seminar, lomba, atau lokasi..."
                           class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Dropdown Kategori -->
                <div class="sm:col-span-4">
                    <select name="kategori" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Submit -->
                <div class="sm:col-span-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-[#1e1b4b] hover:bg-[#2e1065] text-white font-bold text-sm rounded-xl transition shadow-sm">
                        Filter Event
                    </button>
                </div>

            </form>
        </div>

        <!-- Event Cards Grid -->
        <div>
            @if($events->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $ev)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-md transition">
                            
                            <!-- Poster / Header Image -->
                            <div class="aspect-[16/9] bg-gradient-to-tr from-purple-900 to-indigo-800 relative flex items-center justify-center overflow-hidden">
                                @if($ev->poster_path)
                                    <img src="{{ asset('storage/' . $ev->poster_path) }}" alt="{{ $ev->judul_event }}" class="w-full h-full object-cover">
                                @else
                                    <div class="p-4 text-center text-white/70 space-y-1">
                                        <svg class="w-8 h-8 mx-auto text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold block text-white">{{ $ev->kategori->nama_kategori ?? 'Kegiatan' }}</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-bold text-white shadow-sm" style="background-color: {{ $ev->kategori->warna_badge ?? '#7c3aed' }}">
                                    {{ $ev->kategori->nama_kategori ?? 'Event' }}
                                </span>
                            </div>

                            <!-- Content Info -->
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-2">
                                    <span class="text-xs font-semibold text-indigo-600 block">
                                        {{ $ev->benefitSkp->nama_benefit ?? 'SKP Mahasiswa' }} ({{ $ev->benefitSkp->bobot_poin ?? 0 }} Poin)
                                    </span>
                                    <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">
                                        {{ $ev->judul_event }}
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $ev->deskripsi }}
                                    </p>
                                </div>

                                <div class="space-y-3 pt-3 border-t border-slate-100 text-xs">
                                    <div class="flex items-center justify-between text-slate-500">
                                        <span>📅 {{ \Carbon\Carbon::parse($ev->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                                        <span class="truncate max-w-[120px]">📍 {{ $ev->lokasi_atau_platform }}</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-slate-700 truncate max-w-[150px]">
                                            By {{ $ev->user->name ?? 'Ormawa' }}
                                        </span>
                                        <a href="{{ $ev->link_pendaftaran }}" target="_blank" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs transition">
                                            Daftar &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="pt-6">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State Card (Sesuai Screenshot User) -->
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 shadow-sm max-w-3xl mx-auto">
                    <p class="text-sm text-slate-600">
                        Belum ada event yang dipublikasikan. Silakan masuk sebagai Ormawa untuk memposting event pertama!
                    </p>
                </div>
            @endif
        </div>

    </main>

    <!-- FOOTER (Sesuai Screenshot User) -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; 2026 EVENTUNA &mdash; Sistem Informasi Manajemen Event & SKP Mahasiswa Universitas Airlangga.
    </footer>

</div>
@endsection
