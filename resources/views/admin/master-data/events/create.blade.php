@extends('layouts.app')

@section('title', 'Ajukan Event Baru (T1) - EVENTUNA')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengajuan Event Baru (T1)</h1>
        <p class="text-sm text-slate-500">Lengkapi informasi utama kegiatan (Header) dan susunan rundown acara (Detail).</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- BAGIAN 1: HEADER EVENT -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-indigo-950 border-b border-slate-100 pb-2">1. Informasi Utama Event (Header)</h2>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Event</label>
                <input type="text" name="judul_event" value="{{ old('judul_event') }}" required
                       placeholder="Contoh: Kuliah Tamu Artificial Intelligence & Cloud 2026"
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Event</label>
                    <select name="kategori_id" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Benefit & Poin SKP</label>
                    <select name="benefit_skp_id" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white">
                        <option value="" disabled selected>-- Pilih Benefit SKP --</option>
                        @foreach($benefits as $ben)
                            <option value="{{ $ben->id }}" @selected(old('benefit_skp_id') == $ben->id)>
                                {{ $ben->nama_benefit }} ({{ $ben->bobot_poin }} Poin)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Lokasi / Platform</label>
                    <input type="text" name="lokasi_atau_platform" value="{{ old('lokasi_atau_platform') }}" required
                           placeholder="Aula Gedung Vokasi / Zoom Meeting"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Link Pendaftaran</label>
                    <input type="url" name="link_pendaftaran" value="{{ old('link_pendaftaran') }}" required
                           placeholder="https://forms.gle/..."
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Kegiatan</label>
                <textarea name="deskripsi" rows="3" required placeholder="Jelaskan tujuan dan sasaran peserta kegiatan..."
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Poster Event (JPG/PNG, Maks 2MB)</label>
                    <input type="file" name="poster_path" accept="image/*"
                           class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-purple-50 file:text-purple-700 file:font-semibold">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status_publikasi" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white">
                        <option value="published" @selected(old('status_publikasi') == 'published')>Langsung Terbitkan (Published)</option>
                        <option value="draft" @selected(old('status_publikasi') == 'draft')>Simpan sebagai Draft</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: DETAIL RUNDOWN ACARA (MULTI-BARIS DINAMIS) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <div>
                    <h2 class="text-base font-bold text-indigo-950">2. Susunan Rundown Acara (Detail)</h2>
                    <p class="text-xs text-slate-500">Tambahkan minimal 1 sesi kegiatan pada jadwal acara.</p>
                </div>
                <button type="button" id="btn-tambah-sesi"
                        class="px-3.5 py-2 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-xl hover:bg-indigo-100 transition">
                    + Tambah Baris Sesi
                </button>
            </div>

            <div id="rundown-wrapper" class="space-y-3">
                <div class="rundown-item grid grid-cols-1 md:grid-cols-12 gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mulai</label>
                        <input type="time" name="rundowns[0][waktu_mulai]" required class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Selesai</label>
                        <input type="time" name="rundowns[0][waktu_selesai]" required class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Sesi / Agenda</label>
                        <input type="text" name="rundowns[0][nama_sesi]" placeholder="Registrasi & Pembukaan" required class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pemateri / PIC</label>
                        <input type="text" name="rundowns[0][pemateri_atau_pic]" placeholder="MC / Divisi Acara" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-1 flex items-end justify-end">
                        <button type="button" onclick="hapusBaris(this)" class="px-2.5 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('events.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-purple-700 hover:bg-purple-800 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Simpan Pengajuan Event
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let sesiIndex = 1;

    document.getElementById('btn-tambah-sesi').addEventListener('click', function () {
        const wrapper = document.getElementById('rundown-wrapper');
        const barisBaru = document.createElement('div');
        barisBaru.className = 'rundown-item grid grid-cols-1 md:grid-cols-12 gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200';
        barisBaru.innerHTML = `
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Mulai</label>
                <input type="time" name="rundowns[${sesiIndex}][waktu_mulai]" required class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Selesai</label>
                <input type="time" name="rundowns[${sesiIndex}][waktu_selesai]" required class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white">
            </div>
            <div class="md:col-span-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Sesi / Agenda</label>
                <input type="text" name="rundowns[${sesiIndex}][nama_sesi]" placeholder="Sesi Materi Utama" required class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pemateri / PIC</label>
                <input type="text" name="rundowns[${sesiIndex}][pemateri_atau_pic]" placeholder="Narasumber" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white">
            </div>
            <div class="md:col-span-1 flex items-end justify-end">
                <button type="button" onclick="hapusBaris(this)" class="px-2.5 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg">
                    Hapus
                </button>
            </div>
        `;
        wrapper.appendChild(barisBaru);
        sesiIndex++;
    });

    function hapusBaris(tombol) {
        const semuaBaris = document.querySelectorAll('.rundown-item');
        if (semuaBaris.length > 1) {
            tombol.closest('.rundown-item').remove();
        } else {
            alert('Minimal harus terdapat 1 sesi rundown dalam satu event.');
        }
    }
</script>
@endpush