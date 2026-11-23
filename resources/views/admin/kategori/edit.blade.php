@extends('layouts.app')

@section('title', 'Edit Kategori Event (M1) - EVENTUNA Admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-700 hover:underline mb-2">
            &larr; Kembali ke Daftar Kategori
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Kategori Event (M1)</h1>
        <p class="text-sm text-slate-500">Perbarui data nama kategori atau palet warna badge.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
            <div class="font-bold mb-1">Terdapat kesalahan input:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                Nama Kategori <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required maxlength="50"
                   class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('nama_kategori') border-rose-400 @enderror">
            @error('nama_kategori')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                Warna Badge (Hex Code) <span class="text-rose-500">*</span>
            </label>
            <div class="flex items-center gap-4">
                <input type="color" id="badge_color_picker" name="warna_badge"
                       value="{{ old('warna_badge', $kategori->warna_badge) }}" required
                       class="h-12 w-20 p-1 border border-slate-300 rounded-xl cursor-pointer">
                <input type="text" id="badge_color_text"
                       value="{{ old('warna_badge', $kategori->warna_badge) }}"
                       class="w-36 px-3.5 py-2.5 text-sm font-mono border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none"
                       readonly>
                <div class="flex-1">
                    <span id="badge_preview" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold text-white shadow-sm"
                          style="background-color: {{ old('warna_badge', $kategori->warna_badge) }}">
                        {{ old('nama_kategori', $kategori->nama_kategori) }}
                    </span>
                </div>
            </div>
            @error('warna_badge')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.kategori.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-purple-700 hover:bg-purple-800 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Perbarui Kategori
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const picker = document.getElementById('badge_color_picker');
    const text = document.getElementById('badge_color_text');
    const preview = document.getElementById('badge_preview');

    picker.addEventListener('input', function() {
        text.value = this.value;
        preview.style.backgroundColor = this.value;
    });
</script>
@endpush
@endsection
