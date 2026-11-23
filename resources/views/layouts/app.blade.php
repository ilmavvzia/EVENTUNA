<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EVENTUNA - Portal Informasi Event & SKP Mahasiswa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar Utama Dinamis (Publik, Ormawa, & Admin) -->
    <nav class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}"
               class="text-xl font-bold tracking-wide text-purple-300 hover:text-white transition">
                EVENTUNA
            </a>
            @auth
                <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100">
                    {{ auth()->user()->role->label ?? 'Pengguna' }}
                </span>
            @endauth
        </div>

        <div class="flex items-center gap-4 text-sm">
            <!-- Link Katalog Publik (Selalu tampil untuk semua pengunjung) -->
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                Beranda Event
            </a>

            <!-- Jika Pengunjung Umum (Belum Login): Tampilkan Akses Profil Ormawa -->
            @guest
                <span class="text-purple-400">|</span>
                <a href="{{ route('register.ormawa') }}"
                   class="{{ request()->routeIs('register.ormawa') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                    Daftar Akun Ormawa
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-full shadow-sm transition">
                    <span>👤</span>
                    <span>Profil / Masuk</span>
                </a>
            @endguest

            <!-- Jika Sudah Login (Admin atau Ormawa) -->
            @auth
                <span class="text-purple-400">|</span>

                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.master.index') }}"
                       class="{{ request()->routeIs('admin.master.*') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                        Data Master Terpadu
                    </a>
                    <span class="text-purple-400">|</span>
                    <a href="{{ route('admin.kategori.index') }}"
                       class="{{ request()->routeIs('admin.kategori.*') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                        M1: Kategori Event
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                        Dashboard Ormawa
                    </a>
                    @if(Route::has('events.index'))
                        <span class="text-purple-400">|</span>
                        <a href="{{ route('events.index') }}"
                           class="{{ request()->routeIs('events.index') ? 'font-semibold text-white' : 'text-purple-200 hover:text-white transition' }}">
                            Event Saya
                        </a>
                    @endif
                    @if(Route::has('events.create'))
                        <span class="text-purple-400">|</span>
                        <a href="{{ route('events.create') }}"
                           class="px-3 py-1.5 bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold rounded-full transition">
                            + Posting Event (T1)
                        </a>
                    @endif
                @endif

                <span class="text-purple-400">|</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-rose-300 hover:text-rose-200 font-medium transition">
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Konten Halaman -->
    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400 mt-10">
        &copy; {{ date('Y') }} EVENTUNA — Sistem Informasi Manajemen Event & SKP Mahasiswa
    </footer>

    @stack('scripts')
</body>
</html>