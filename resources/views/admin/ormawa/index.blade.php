@extends('layouts.app')

@section('title', 'Manajemen Organisasi Mahasiswa - EVENTUNA')

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
            <a href="{{ route('admin.approval.index') }}" class="text-slate-300 hover:text-white transition">Approval Event</a>
            <a href="{{ route('admin.ormawa.index') }}" class="text-white font-semibold underline underline-offset-8 decoration-purple-400">Manajemen Ormawa</a>
            <a href="{{ route('admin.master.index') }}" class="text-slate-300 hover:text-white transition">Data Master</a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Direktori Organisasi Mahasiswa</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data profil, berkas SK kepengurusan, dan verifikasi akun Ormawa Universitas Airlangga.</p>
            </div>
            <a href="{{ route('admin.ormawa.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ormawa
            </a>
        </div>

        <!-- Flash Notifications -->
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

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <form action="{{ route('admin.ormawa.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                
                <!-- Input Cari Nama / Email -->
                <div class="sm:col-span-5 relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama organisasi atau email..."
                           class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Filter Status -->
                <div class="sm:col-span-3">
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">Semua Status Akun</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified (Aktif)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                    </select>
                </div>

                <!-- Filter Fakultas -->
                <div class="sm:col-span-3">
                    <select name="fakultas_id" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">Semua Fakultas</option>
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}" {{ request('fakultas_id') == $fak->id ? 'selected' : '' }}>
                                {{ $fak->nama_fakultas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Submit & Reset -->
                <div class="sm:col-span-1 flex items-center gap-2">
                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white py-2 px-3 rounded-xl text-sm font-semibold transition text-center">
                        Cari
                    </button>
                    @if(request()->hasAny(['search', 'status', 'fakultas_id']))
                        <a href="{{ route('admin.ormawa.index') }}" title="Reset Filter" class="p-2 border border-slate-300 rounded-xl text-slate-500 hover:bg-slate-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table Data Ormawa -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-semibold text-center w-12">No</th>
                            <th class="py-3.5 px-4 font-semibold">Organisasi</th>
                            <th class="py-3.5 px-4 font-semibold">Fakultas / Jenis</th>
                            <th class="py-3.5 px-4 font-semibold text-center">Status Akun</th>
                            <th class="py-3.5 px-4 font-semibold text-center">Event</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($ormawas as $index => $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-4 text-center text-slate-500 font-medium">
                                    {{ $ormawas->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->logo_path)
                                            <img src="{{ asset('storage/' . $item->logo_path) }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center shrink-0 text-sm shadow-sm">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.ormawa.show', $item->id) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition">
                                                {{ $item->name }}
                                            </a>
                                            <div class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <span>{{ $item->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-medium text-slate-800">
                                        {{ $item->fakultas->nama_fakultas ?? 'Tingkat Universitas' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        <span class="inline-block bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-semibold text-[11px]">
                                            {{ $item->jenisOrmawa->nama_jenis ?? 'Umum' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_akun === 'verified')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Verified
                                        </span>
                                    @elseif($item->status_akun === 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-lg text-xs">
                                        {{ $item->events_count }} Event
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Quick Verify / Reject jika status pending -->
                                        @if($item->status_akun === 'pending')
                                            <form action="{{ route('admin.ormawa.verify', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi dan aktifkan akun {{ $item->name }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Verifikasi Akun" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                                    <span>&check;</span> Verifikasi
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Tombol Detail -->
                                        <a href="{{ route('admin.ormawa.show', $item->id) }}"
                                           title="Lihat Detail Profil & Event"
                                           class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition">
                                            Detail
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.ormawa.edit', $item->id) }}"
                                           title="Edit Ormawa"
                                           class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-semibold transition">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.ormawa.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ormawa \'{{ $item->name }}\'?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Hapus Ormawa"
                                                    class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg text-xs font-semibold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center">
                                    <div class="max-w-sm mx-auto text-slate-500 space-y-2">
                                        <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="font-semibold text-slate-700">Tidak ada data organisasi mahasiswa.</p>
                                        <p class="text-xs">Coba ubah kata kunci pencarian atau tambah organisasi baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($ormawas->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $ormawas->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; 2026 EVENTUNA &mdash; Portal Informasi Kegiatan & Manajemen SKP Mahasiswa Universitas Airlangga.
    </footer>

</div>
@endsection
