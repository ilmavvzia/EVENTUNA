<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTUNA - Portal Penyelenggara Kegiatan Kampus</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Plus Jakarta Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-[#eef2f6] min-h-screen flex items-center justify-center p-2 sm:p-4 text-slate-800">

    <!-- Card Wrapper -->
    <div class="w-full max-w-[960px] bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-slate-100">
        
        <!-- ==================== SISI KIRI (PANEL NAVY GELAP) ==================== -->
        <div class="md:col-span-5 bg-gradient-to-b from-[#1e2a44] to-[#121929] text-white p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <!-- Brand Header -->
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center p-1 shadow-sm">
                        <svg class="w-full h-full text-[#1e2a44]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"/>
                            <path d="M7 7h10"/>
                            <path d="M7 12h10"/>
                            <path d="M7 17h6"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold tracking-tight leading-none text-white">EVENTUNA</h2>
                        <span class="text-[8px] text-slate-400 font-semibold tracking-wider block mt-0.5">CAMPUS MANAGEMENT PLATFORM</span>
                    </div>
                </div>

                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-white/10 rounded-full text-[10px] font-medium text-slate-300 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> PORTAL RESMI PENYELENGGARA KEGIATAN KAMPUS
                </div>

                <!-- Judul Utama -->
                <h1 class="text-xl sm:text-[22px] font-bold text-white leading-snug mb-2.5">
                    Publikasikan Kegiatan Organisasimu, Jangkau Seluruh Kampus.
                </h1>

                <p class="text-[11px] text-slate-300 leading-relaxed mb-5">
                    Satu pintu bagi BEM, HIMA, dan UKM untuk mempublikasikan agenda seminar, webinar, kompetisi, dan workshop kepada ribuan mahasiswa secara mudah dan transparan.
                </p>

                <!-- 4 Box Fitur / Benefit -->
                <div class="space-y-2.5">
                    <!-- Fitur 1: Ungu Petir -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 flex items-start gap-2.5">
                        <div class="w-6 h-6 rounded-md bg-[#4f46e5] flex items-center justify-center shrink-0 text-white mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Publikasi Cepat & Mandiri</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">Rilis info event dan link pendaftaran eksternal dalam hitungan menit tanpa birokrasi berbelit.</p>
                        </div>
                    </div>

                    <!-- Fitur 2: Oranye Tameng -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 flex items-start gap-2.5">
                        <div class="w-6 h-6 rounded-md bg-[#d97706] flex items-center justify-center shrink-0 text-white mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Informasi SKP & Benefit Terstandar</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">Cantumkan bobot SKP resmi dan sertifikat secara transparan untuk memikat minat peserta.</p>
                        </div>
                    </div>

                    <!-- Fitur 3: Ungu Tautan -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 flex items-start gap-2.5">
                        <div class="w-6 h-6 rounded-md bg-[#4f46e5] flex items-center justify-center shrink-0 text-white mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Kontrol Penuh Tautan Registrasi</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">Arahkan peserta langsung ke Google Form, landing page kepanitiaan, atau sistem ticketing ormawa.</p>
                        </div>
                    </div>

                    <!-- Fitur 4: Abu Galeri -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 flex items-start gap-2.5">
                        <div class="w-6 h-6 rounded-md bg-slate-600/80 flex items-center justify-center shrink-0 text-white mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">Direktori Profil Organisasi</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">Tampilkan portofolio rekam jejak kegiatan ormawa Anda di etalase publik terverifikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== SISI KANAN (FORM LOGIN LENGKAP) ==================== -->
        <div class="md:col-span-7 p-6 sm:p-7 flex flex-col justify-between bg-white">
            <div>
                <!-- Badge Atas -->
                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#eef4ff] text-[#2563eb] mb-2">
                    <svg class="w-3 h-3 text-[#2563eb]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L2 9v2h20V9L12 3zm-7 8v7h3v-7H5zm5 0v7h4v-7h-4zm6 0v7h3v-7h-3zM2 20v2h20v-2H2z"/>
                    </svg>
                    <span>Khusus Akun Pengurus / Organisasi Kampus</span>
                </div>

                <!-- Judul Form -->
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight leading-tight">Masuk ke Dashboard Organisasi</h2>
                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                    Kelola publikasi kegiatan, perbarui informasi event, dan pantau rekam jejak agenda ormawa Anda. Mahasiswa umum tidak memerlukan akun untuk melihat kegiatan.
                </p>

                <!-- Form Masuk -->
                <form action="#" method="POST" class="mt-4 space-y-3">
                    @csrf
                    <!-- Input Email -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-semibold text-slate-800">Email Resmi Organisasi / PIC</label>
                            <span class="text-[10px] text-slate-400">Domain Kampus / Ormawa</span>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" name="email" required placeholder="contoh: himati@univ.ac.id atau bpm.bem@univ.ac.id" 
                                   class="w-full pl-9 pr-3 py-2 text-xs bg-[#f4f7fb] border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 focus:outline-none transition placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Input Sandi -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-semibold text-slate-800">Kata Sandi Akun</label>
                            <a href="#" class="text-xs font-semibold text-[#2b26c7] hover:underline">Lupa Kata Sandi?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" name="password" required placeholder="••••••••••••" 
                                   class="w-full pl-9 pr-9 py-2 text-xs bg-[#f4f7fb] border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 focus:outline-none transition placeholder:text-slate-400">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-3.5 h-3.5 text-[#2b26c7] border-slate-300 rounded focus:ring-indigo-500">
                        <label for="remember" class="ml-2 block text-[11px] text-slate-600 select-none">
                            Ingat akun organisasi ini di perangkat sekretariat / peribadi ini
                        </label>
                    </div>

                    <!-- Tombol Masuk Utama -->
                    <button type="submit" 
                            class="w-full py-2.5 bg-[#251ec7] hover:bg-[#1e17ab] text-white font-semibold text-xs rounded-lg shadow-sm transition flex items-center justify-center gap-1.5">
                        <span>Masuk ke Dashboard Organisasi</span>
                        <span>&rarr;</span>
                    </button>
                </form>

                <!-- Pemisah Divider -->
                <div class="relative my-3 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <span class="relative bg-white px-2.5 text-[9px] uppercase font-bold tracking-wider text-slate-400">
                        Atau Otentikasi Cepat
                    </span>
                </div>

                <!-- Tombol Google Workspace Kampus -->
                <button type="button" class="w-full py-2 px-3 border border-slate-200 bg-[#eef4ff]/60 hover:bg-[#eef4ff] rounded-lg text-[11px] font-semibold text-slate-700 transition flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Masuk dengan Akun Ormawa Terintegrasi (Google Workspace Kampus)</span>
                </button>

                <!-- Box Ajukan Akun Baru -->
                <div class="mt-3.5 bg-[#f0f5ff] border border-[#d9e7ff] rounded-xl p-3">
                    <div class="flex items-start gap-2.5">
                        <div class="w-4 h-4 rounded border border-blue-400 text-blue-600 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">
                            ?
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Organisasi Anda belum terdaftar di direktori EVENTUNA?</h4>
                            <p class="text-[10px] text-slate-500 mt-0.5 leading-snug">
                                Pengajuan akun organisasi memerlukan SK Kepengurusan aktif dari Dekanat / Rektorat Kemahasiswaan untuk verifikasi integritas publik.
                            </p>
                            <a href="#" class="inline-flex items-center gap-1 text-[11px] font-bold text-[#2563eb] hover:underline mt-1 transition">
                                <span>Ajukan Pendaftaran Akun Organisasi Baru</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bawah -->
            <div class="mt-5 pt-2 flex items-center justify-between text-[11px] text-slate-400">
                <a href="/" class="hover:text-slate-600 flex items-center gap-1">
                    <span>&larr;</span> Kembali ke Jelajah Event (Akses Publik)
                </a>
                <span class="flex items-center gap-1 text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Versi Portal v2.4
                </span>
            </div>
        </div>

    </div>

</body>
</html>