@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Master Kategori Event (M1)</h1>
            <p class="text-sm text-slate-500">Kelola jenis kategori kegiatan mahasiswa beserta warna badge tampilan.</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition">
            + Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('admin.kategori.index') }}" class="mb-5 flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Cari nama kategori event..."
               class="w-full sm:w-80 px-4 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        <button type="submit"
                class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-xl hover:bg-slate-700">
            Cari
        </button>
        @if (!empty($search))
            <a href="{{ route('admin.kategori.index') }}"
               class="px-4 py-2 bg-slate-100 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-200">
                Reset
            </a>
        @endif
    </form>

    <!-- Tabel Data -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                <tr>
                    <th class="py-3.5 px-5">No</th>
                    <th class="py-3.5 px-5">Nama Kategori</th>
                    <th class="py-3.5 px-5">Preview Badge</th>
                    <th class="py-3.5 px-5 text-center">Dipakai Event</th>
                    <th class="py-3.5 px-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($kategoris as $index => $item)
                    <tr class="hover:bg-slate-50/70">
                        <td class="py-3.5 px-5 text-slate-500">{{ $kategoris->firstItem() + $index }}</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-800">{{ $item->nama_kategori }}</td>
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white"
                                  style="background-color: {{ $item->warna_badge }}">
                                {{ $item->nama_kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-center text-slate-600">{{ $item->events_count }}</td>
                        <td class="py-3.5 px-5 text-right space-x-2">
                            <a href="{{ route('admin.kategori.edit', $item) }}"
                               class="inline-block px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100">
                                Edit
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-5 text-center text-slate-400">
                            Belum ada data kategori event.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection