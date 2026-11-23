<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Portal Pengurus - EVENTUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-6">

    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12">

        <!-- PANEL KIRI: INFORMASI PLATFORM -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#1e1b4b] via-[#312e81] to-[#581c87] text-white p-8 md:p-10 flex flex-col justify-between relative overflow-hidden">
            <!-- Dekorasi Latar -->
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-purple-500/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-20 -left-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-2xl font-extrabold tracking-wide text-white">
                    <span class="w-9 h-9 rounded-xl bg-purple-500/30 border border-purple-400/40 flex items-center justify-center text-purple-200 text-lg">
                        E
                    </span>
                    EVENTUNA
                </a>
                <p class="mt-2 text-xs uppercase tracking-widest text-purple-300 font-semibold">
                    Portal Kegiatan & Ormawa Kampus
                </p>

                <h1 class="mt-8 text-2xl md:text-3xl font-bold leading-snug">
                    Kelola & Publikasikan Event Organisasi Mahasiswa dalam Satu Pintu.
                </h1>
                <p class="mt-3 text-sm text-indigo-200 leading-relaxed">
                    Platform terintegrasi bagi pengurus BEM, HIMA, dan UKM untuk menjangkau seluruh mahasiswa serta mengelola informasi benefit SKP secara terpusat.
                </p>

                <div class="mt-8 space-y-4 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-lg bg-purple-500/30 text-purple-200 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                        <div>
                            <p class="font-semibold text-white">Publikasi Terverifikasi</p>
                            <p class="text-xs text-indigo-200">Kredibilitas kegiatan terjamin dengan status verifikasi resmi kemahasiswaan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-lg bg-purple-500/30 text-purple-200 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                        <div>
                            <p class="font-semibold text-white">Transparansi Bobot SKP</p>
                            <p class="text-xs text-indigo-200">Informasi kategori kegiatan dan poin SKP tampil jelas bagi calon peserta.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-lg bg-purple-500/30 text-purple-200 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                        <div>
                            <p class="font-semibold text-white">Akses Pendaftaran Fleksibel</p>
                            <p class="text-xs text-indigo-200">Terhubung langsung ke tautan registrasi eksternal panitia tanpa hambatan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-indigo-300">
                <span>&copy; 2026 EVENTUNA</span>
                <a href="{{ url('/') }}" class="hover:text-white underline transition">Kembali ke Beranda</a>
            </div>
        </div>

        <!-- PANEL KANAN: FORMULIR LOGIN -->
        <div class="lg:col-span-7 p-8 md:p-12 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-2xl font-bold text-slate-900">Selamat Datang Kembali</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Masuk menggunakan akun Pengurus Ormawa atau Super Admin Kemahasiswaan.
                </p>

                <!-- Notifikasi Sukses (misal setelah Logout atau Registrasi) -->
                @if(session('success'))
                    <div class="mt-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Notifikasi Error Validasi / Akun Belum Diverifikasi -->
                @if($errors->any())
                    <div class="mt-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Formulir Autentikasi -->
                <form action="{{ route('login.authenticate') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Email Resmi Organisasi / Admin
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="contoh: himti@vokasi.unair.ac.id"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-700">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                placeholder="Masukkan kata sandi Anda"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition pr-12">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 px-3.5 text-xs font-semibold text-slate-400 hover:text-purple-700 transition">
                                Lihat
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="inline-flex items-center gap-2 text-slate-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-purple-700 focus:ring-purple-600">
                            <span>Ingat sesi masuk saya</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 bg-purple-700 hover:bg-purple-800 text-white font-semibold text-sm rounded-xl shadow-md shadow-purple-700/20 transition cursor-pointer">
                        Masuk ke Portal
                    </button>
                </form>

                <!-- Info Akun Uji Coba & Pendaftaran Ormawa Baru -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-slate-800">Ormawa Anda belum terdaftar?</p>
                            <p class="text-xs text-slate-500 mt-0.5">Ajukan akun pengurus resmi dengan melampirkan SK Kepengurusan.</p>
                        </div>
                        <a href="{{ Route::has('register.ormawa') ? route('register.ormawa') : '#' }}"
                            class="shrink-0 text-center px-4 py-2 rounded-xl bg-white border border-purple-200 text-purple-700 hover:bg-purple-50 text-xs font-semibold transition">
                            Daftar Akun Ormawa
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn = event.currentTarget;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Tutup';
            } else {
                input.type = 'password';
                btn.textContent = 'Lihat';
            }
        }
    </script>
</body>
</html>