
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Organisasi - EVENTUNA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#1e2a44] text-white min-h-screen hidden md:flex flex-col">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-white/10">
            <h1 class="text-2xl font-extrabold tracking-wide">
                EVENTUNA
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                CAMPUS MANAGEMENT PLATFORM
            </p>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2">

            <p class="text-xs text-slate-400 uppercase font-bold px-3 mb-3">
                Menu Utama
            </p>

            <a href="/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#4f46e5] text-white">
                <span>▦</span>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <span>▣</span>
                <span class="text-sm">Kelola Event</span>
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <span>＋</span>
                <span class="text-sm">Tambah Event</span>
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <span>♙</span>
                <span class="text-sm">Pendaftaran</span>
            </a>

            <p class="text-xs text-slate-400 uppercase font-bold px-3 pt-6 mb-3">
                Pengaturan
            </p>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <span>⚙</span>
                <span class="text-sm">Profil Organisasi</span>
            </a>

        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center font-bold">
                    O
                </div>
                <div>
                    <p class="text-sm font-semibold">Organisasi</p>
                    <p class="text-xs text-slate-400">Pengurus Kampus</p>
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
                    Dashboard
                </h2>
                <p class="text-xs text-slate-500">
                    Portal Pengelolaan Kegiatan Organisasi
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button class="w-9 h-9 rounded-full bg-slate-100">
                    ♧
                </button>

                <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    O
                </div>
            </div>

        </header>

        <!-- CONTENT -->
        <section class="p-6">

            <!-- Welcome -->
            <div class="mb-7">
                <h1 class="text-2xl font-bold text-slate-900">
                    Selamat Datang, Organisasi! 👋
                </h1>

                <p class="text-sm text-slate-500 mt-2">
                    Kelola dan pantau seluruh kegiatan organisasi Anda melalui EVENTUNA.
                </p>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm text-slate-500">Total Event</p>
                    <h2 class="text-3xl font-extrabold mt-3">12</h2>
                    <p class="text-xs text-indigo-600 mt-2">Seluruh kegiatan</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm text-slate-500">Event Aktif</p>
                    <h2 class="text-3xl font-extrabold text-green-600 mt-3">5</h2>
                    <p class="text-xs text-slate-400 mt-2">Sedang dipublikasikan</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm text-slate-500">Event Selesai</p>
                    <h2 class="text-3xl font-extrabold text-blue-600 mt-3">7</h2>
                    <p class="text-xs text-slate-400 mt-2">Kegiatan terlaksana</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm text-slate-500">Total Pendaftar</p>
                    <h2 class="text-3xl font-extrabold text-purple-600 mt-3">248</h2>
                    <p class="text-xs text-slate-400 mt-2">Seluruh kegiatan</p>
                </div>

            </div>

            <!-- Event Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                <div class="p-5 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800">
                            Event Terbaru
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Daftar kegiatan organisasi Anda
                        </p>
                    </div>

                    <a href="#"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                        + Tambah Event
                    </a>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">

                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-5 py-4">Nama Event</th>
                                <th class="px-5 py-4">Tanggal</th>
                                <th class="px-5 py-4">Kategori</th>
                                <th class="px-5 py-4">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            <tr>
                                <td class="px-5 py-4 font-semibold">Seminar Teknologi Digital</td>
                                <td class="px-5 py-4">15 November 2026</td>
                                <td class="px-5 py-4">Seminar</td>
                                <td class="px-5 py-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Aktif
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-5 py-4 font-semibold">Workshop UI/UX Design</td>
                                <td class="px-5 py-4">20 November 2026</td>
                                <td class="px-5 py-4">Workshop</td>
                                <td class="px-5 py-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                        Draft
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-5 py-4 font-semibold">Kompetisi Programming</td>
                                <td class="px-5 py-4">25 November 2026</td>
                                <td class="px-5 py-4">Kompetisi</td>
                                <td class="px-5 py-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Aktif
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>
