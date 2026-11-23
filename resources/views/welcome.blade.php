@extends('layouts.app')

@section('title', 'EVENTUNA - Portal Event & Lomba Mahasiswa')

@section('content')
<!-- Hero Banner & Akses Profil Ormawa -->
<div class="bg-gradient-to-br from-[#1e1b4b] via-indigo-950 to-purple-900 text-white py-12 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="max-w-2xl space-y-3">
            <span class="inline-block text-xs font-semibold tracking-wider uppercase bg-purple-500/30 text-purple-200 px-3 py-1 rounded-full">
                Portal Informasi Kegiatan & SKP Mahasiswa
            </span>
            <h1 class="text-3xl md:text-4xl font-bold leading-tight">
                Temukan Seminar, Lomba, & Pelatihan Kampus Terbaru
            </h1>
            <p class="text-sm md:text-base text-purple-200">
                Jelajahi berbagai event resmi dari BEM, HIMA, dan UKM tanpa perlu login. Pengurus Ormawa dapat mendaftarkan profil organisasinya untuk mempublikasikan event.
            </p>
        </div>

        <!-- Kartu Profil / Akses Ormawa -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl w-full md:w-80 space-y-3">
            @guest
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-400/30 flex items-center justify-center font-bold text-purple-100">
                        👤
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">Profil Pengurus Ormawa</div>
                        <div class="text-xs text-purple-200">Ingin memposting event / lomba?</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('login') }}"
                       class="text-center py-2 px-3 bg-white text-indigo-950 text-xs font-bold rounded-xl hover:bg-purple-50 transition">
                        Masuk Akun
                    </a>
                    <a href="{{ route('register.ormawa') }}"
                       class="text-center py-2 px-3 bg-purple-600 text-white text-xs font-bold rounded-xl hover:bg-purple-500 transition">
                        Daftar Ormawa
                    </a>
                </div>
            @else
                <div class="text-xs text-purple-200">Masuk sebagai:</div>
                <div class="text-sm font-bold text-white">{{ auth()->user()->name }}</div>
                <div class="pt-1">
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.kategori.index') }}"
                           class="block text-center py-2 px-4 bg-white text-indigo-950 text-xs font-bold rounded-xl">
                            Buka Panel Admin
                        </a>
                    @else
                        <a href="{{ route('events.create') }}"
                           class="block text-center py-2 px-4 bg-purple-500 hover:bg-purple-400 text-white text-xs font-bold rounded-xl">
                            + Posting Event Baru
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</div>

<!-- Filter & Katalog Event -->
<div class="max-w-6xl mx-auto px-4 py-8">
    <form method="GET" action="{{ route('home') }}" class="flex flex-col sm:flex-row gap-3 mb-8">
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Cari judul seminar, lomba, atau lokasi..."
               class="flex-1 px-4 py-2.5 text-sm border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-purple-600 focus:outline-none">

        <select name="kategori" class="sm:w-56 px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" @selected(($kategoriId ?? '') == $kat->id)>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="px-5 py-2.5 bg-indigo-950 text-white text-sm font-semibold rounded-xl hover:bg-indigo-900">
            Filter Event
        </button>
    </form>

    <!-- Grid Kartu Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                <div>
                    @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->judul_event }}"
                             class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-44 bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-400 text-xs font-semibold">
                            Poster Event {{ $event->user->name ?? 'Ormawa' }}
                        </div>
                    @endif

                    <div class="p-5 space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold text-white"
                                  style="background-color: {{ $event->kategori->warna_badge ?? '#4f46e5' }}">
                                {{ $event->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                                +{{ $event->benefitSkp->bobot_poin ?? 0 }} SKP
                            </span>
                        </div>

                        <h2 class="text-base font-bold text-slate-900 line-clamp-2">
                            {{ $event->judul_event }}
                        </h2>

                        <p class="text-xs text-slate-500">
                            Penyelenggara: <span class="font-semibold text-slate-700">{{ $event->user->name ?? '-' }}</span>
                        </p>

                        <div class="text-xs text-slate-600 space-y-1 pt-1">
                            <div>📅 {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</div>
                            <div>📍 {{ $event->lokasi_atau_platform }}</div>
                        </div>
                    </div>
                </div>

                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('events.public.show', $event->slug) }}"
                       class="text-xs font-bold text-purple-700 hover:text-purple-900">
                        Lihat Detail & Rundown →
                    </a>
                    <a href="{{ $event->link_pendaftaran }}" target="_blank"
                       class="px-3 py-1.5 bg-purple-700 text-white text-xs font-semibold rounded-lg hover:bg-purple-800">
                        Daftar
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-10 text-center text-slate-400 text-sm">
                Belum ada event yang dipublikasikan. Silakan masuk sebagai Ormawa untuk memposting event pertama!
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection