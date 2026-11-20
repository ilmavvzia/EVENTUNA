<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Master - EVENTUNA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- Navbar Top -->
    <nav class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex justify-between items-center">
        <div class="flex items-center gap-3">
            <span class="text-xl font-bold tracking-wide text-purple-300">EVENTUNA</span>
            <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100">Panel Super Admin</span>
        </div>
        <div class="text-sm text-purple-200">Manajemen Data Master</div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8 space-y-8">

        <!-- Flash Notification -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SECTION 1: KATEGORI EVENT -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">1. Master Kategori Event</h2>
                    <p class="text-sm text-slate-500">Digunakan untuk pengelompokan & filter katalog event mahasiswa.</p>
                </div>
                <form action="{{ route('admin.master.kategori.store') }}" method="POST" class="flex flex-wrap items-center gap-2">
                    @csrf
                    <input type="text" name="nama_kategori" placeholder="Nama kategori baru..." required
                        class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <input type="color" name="warna_badge" value="#7c3aed" title="Pilih warna badge"
                        class="h-9 w-12 border border-slate-300 rounded-lg cursor-pointer">
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                        + Tambah
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 uppercase text-xs">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4">Preview Badge</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($kategoris as $index => $kat)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium">{{ $kat->nama_kategori }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: {{ $kat->warna_badge }}">
                                    {{ $kat->nama_kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.master.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs bg-rose-50 px-3 py-1.5 rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: BENEFIT & BOBOT SKP -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">2. Master Benefit & Bobot SKP</h2>
                    <p class="text-sm text-slate-500">Standar poin SKP dan sertifikat kegiatan kemahasiswaan.</p>
                </div>
                <form action="{{ route('admin.master.benefit.store') }}" method="POST" class="flex flex-wrap items-center gap-2">
                    @csrf
                    <input type="text" name="nama_benefit" placeholder="Nama benefit / SKP..." required
                        class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <input type="number" name="bobot_poin" placeholder="Poin" min="0" max="100" required
                        class="w-24 px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                        + Tambah
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 uppercase text-xs">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Benefit / Sertifikat</th>
                            <th class="py-3 px-4">Bobot SKP</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($benefits as $index => $ben)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium">{{ $ben->nama_benefit }}</td>
                            <td class="py-3 px-4">
                                <span class="bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-lg text-xs">
                                    {{ $ben->bobot_poin }} Poin SKP
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.master.benefit.destroy', $ben->id) }}" method="POST" onsubmit="return confirm('Hapus benefit ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs bg-rose-50 px-3 py-1.5 rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 3: REFERENSI FAKULTAS & JENIS ORMAWA -->
        <div class="grid md:grid-cols-2 gap-6">
            <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-900 mb-3">3. Master Fakultas / Unit</h3>
                <ul class="divide-y divide-slate-100 text-sm">
                    @foreach($fakultas as $fak)
                        <li class="py-2.5 flex justify-between">
                            <span class="font-medium text-slate-700">{{ $fak->nama_fakultas }}</span>
                            <span class="text-xs font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $fak->kode_fakultas }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-900 mb-3">4. Master Jenis Ormawa</h3>
                <ul class="divide-y divide-slate-100 text-sm">
                    @foreach($jenisOrmawas as $jo)
                        <li class="py-2.5">
                            <div class="font-semibold text-slate-800">{{ $jo->nama_jenis }}</div>
                            <div class="text-xs text-slate-500">{{ $jo->deskripsi }}</div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>

    </main>
</body>
</html>