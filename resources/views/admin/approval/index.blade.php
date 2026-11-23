@extends('layouts.app')

@section('title', 'Approval Pengajuan Event - EVENTUNA Admin')

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

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Approval Pengajuan Event Mahasiswa</h1>
                <p class="text-sm text-slate-500 mt-1">Periksa kelengkapan agenda kegiatan dari Ormawa sebelum dipublikasikan ke portal mahasiswa.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $countPending }} Event Perlu Persetujuan
                </span>
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

        <!-- Filter Tab & Search Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 space-y-4">
            
            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-3">
                <a href="{{ route('admin.approval.index') }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ !request('status') ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua ({{ $countAll }})
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'pending']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request('status') === 'pending' ? 'bg-white' : 'bg-amber-500' }}"></span>
                    Menunggu Review ({{ $countPending }})
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'approved']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ request('status') === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request('status') === 'approved' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                    Disetujui ({{ $countApproved }})
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'rejected']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ request('status') === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request('status') === 'rejected' ? 'bg-white' : 'bg-rose-500' }}"></span>
                    Ditolak ({{ $countRejected }})
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.approval.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative flex-1 w-full">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari judul kegiatan atau nama organisasi penyelenggara..."
                           class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition">
                    Cari Event
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.approval.index') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-xs text-slate-600 hover:bg-slate-100 transition text-center">
                        Reset Filter
                    </a>
                @endif
            </form>

        </div>

        <!-- Table Approval Event -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-semibold text-center w-12">No</th>
                            <th class="py-3.5 px-4 font-semibold">Judul Event & Penyelenggara</th>
                            <th class="py-3.5 px-4 font-semibold">Kategori & SKP</th>
                            <th class="py-3.5 px-4 font-semibold">Tanggal Kegiatan</th>
                            <th class="py-3.5 px-4 font-semibold text-center">Status Keputusan</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($events as $index => $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-4 text-center text-slate-500 font-medium">
                                    {{ $events->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1">
                                        <a href="{{ route('admin.approval.show', $item->id) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition block">
                                            {{ $item->judul_event }}
                                        </a>
                                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                                            <span class="font-semibold text-slate-700">{{ $item->user->name ?? 'Ormawa' }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $item->user->fakultas->kode_fakultas ?? 'UNAIR' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold text-white" style="background-color: {{ $item->kategori->warna_badge ?? '#6366f1' }}">
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </span>
                                        <div class="text-xs text-slate-500">
                                            {{ $item->benefitSkp->bobot_poin ?? 0 }} Poin SKP
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-slate-800 font-medium text-xs">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs">
                                        📍 {{ $item->lokasi_atau_platform }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_approval === 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Disetujui
                                        </span>
                                    @elseif($item->status_approval === 'rejected')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu Review
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <a href="{{ route('admin.approval.show', $item->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $item->status_approval === 'pending' ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                                        Tinjau
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-semibold text-slate-700 text-sm">Tidak ada pengajuan event pada kriteria ini.</p>
                                    <p class="text-xs text-slate-500 mt-1">Coba ubah kata kunci atau pilih tab filter status lainnya.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $events->links() }}
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
