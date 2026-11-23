@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Kategori Event</h1>

    <form action="{{ route('admin.kategori.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required
                   placeholder="Contoh: Seminar & Talkshow"
                   class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            @error('nama_kategori')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Warna Badge</label>
            <input type="color" name="warna_badge" value="{{ old('warna_badge', '#4f46e5') }}" required
                   class="h-11 w-24 p-1 border border-slate-300 rounded-xl cursor-pointer">
            @error('warna_badge')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-3 flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700">
                Simpan Kategori
            </button>
            <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2.5 text-sm text-slate-600 hover:text-slate-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection