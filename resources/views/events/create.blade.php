@extends('layouts.app')

@section('title', 'Ajukan Event Baru (T1) - EVENTUNA')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-700 hover:underline mb-2">
            &larr; Kembali ke Daftar Event
        </a>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                Transaksi T1
            </span>
            <h1 class="text-2xl font-bold text-slate-800">Pengajuan Event Baru (Header-Detail)</h1>
        </div>
        <p class="text-sm text-slate-500 mt-1">Lengkapi informasi utama kegiatan (Header) dan susunan multi-baris jadwal acara (Detail Rundown).</p>
    </div>

    <!-- Alert Validasi Server-Side -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-bold mb-1 flex items-center gap-1.5">
                <span>⚠</span>
                <span>Terdapat kesalahan pengisian formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- BAGIAN 1: HEADER EVENT -->
        <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-indigo-950 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">1</span>
                    Informasi Utama Event (Header)
                </h2>
                <span class="text-xs text-slate-400 font-medium">Tabel: events</span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Judul Event / Kegiatan <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul_event" value="{{ old('judul_event') }}" required maxlength="200"
                       placeholder="Contoh: Workshop Fullstack Web Development dengan Laravel 13 & PostgreSQL"
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('judul_event') border-rose-400 @enderror">
                @error('judul_event')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Kategori Event <span class="text-rose-500">*</span>
                    </label>
                    <select name="kategori_id" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-purple-600 focus:outline-none @error('kategori_id') border-rose-400 @enderror">
                        <option value="" disabled selected>-- Pilih Kategori (M1) --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Benefit & Bobot SKP <span class="text-rose-500">*</span>
                    </label>
                    <select name="benefit_skp_id" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-purple-600 focus:outline-none @error('benefit_skp_id') border-rose-400 @enderror">
                        <option value="" disabled selected>-- Pilih Benefit SKP --</option>
                        @foreach($benefits as $ben)
                            <option value="{{ $ben->id }}" @selected(old('benefit_skp_id') == $ben->id)>
                                {{ $ben->nama_benefit }} (+{{ $ben->bobot_poin }} SKP)
                            </option>
                        @endforeach
                    </select>
                    @error('benefit_skp_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Tanggal Mulai <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('tanggal_mulai') border-rose-400 @enderror">
                    @error('tanggal_mulai')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Tanggal Selesai (Opsional)
                    </label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('tanggal_selesai') border-rose-400 @enderror">
                    @error('tanggal_selesai')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Lokasi / Platform <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi_atau_platform" value="{{ old('lokasi_atau_platform') }}" required maxlength="200"
                           placeholder="Contoh: Lab Komputer Gedung B Vokasi / Zoom Meeting"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('lokasi_atau_platform') border-rose-400 @enderror">
                    @error('lokasi_atau_platform')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Link Pendaftaran (URL) <span class="text-rose-500">*</span>
                    </label>
                    <input type="url" name="link_pendaftaran" value="{{ old('link_pendaftaran') }}" required maxlength="255"
                           placeholder="https://forms.gle/..."
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('link_pendaftaran') border-rose-400 @enderror">
                    @error('link_pendaftaran')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Deskripsi Lengkap Kegiatan <span class="text-rose-500">*</span>
                </label>
                <textarea name="deskripsi" rows="3" required placeholder="Tuliskan latar belakang, tujuan, dan sasaran peserta kegiatan..."
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:outline-none @error('deskripsi') border-rose-400 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Poster Event (JPG/PNG/WEBP, Maks 2MB)
                    </label>
                    <input type="file" name="poster_path" accept="image/*"
                           class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-purple-50 file:text-purple-700 file:font-semibold hover:file:bg-purple-100 cursor-pointer">
                    @error('poster_path')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_publikasi" required class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-purple-600 focus:outline-none">
                        <option value="published" @selected(old('status_publikasi') == 'published')>Langsung Terbitkan (Published)</option>
                        <option value="draft" @selected(old('status_publikasi') == 'draft')>Simpan sebagai Draft</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: DETAIL RUNDOWN ACARA (MULTI-BARIS DINAMIS) -->
        <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-bold text-indigo-950 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">2</span>
                        Susunan Rundown Acara (Detail T1)
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tambahkan minimal 1 sesi kegiatan dengan jadwal waktu yang jelas.</p>
                </div>
                <button type="button" id="btn-tambah-sesi"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-xl hover:bg-indigo-100 transition shadow-sm">
                    <span>+</span>
                    <span>Tambah Baris Sesi</span>
                </button>
            </div>

            <div id="rundown-wrapper" class="space-y-3">
                <!-- Baris Pertama Default -->
                <div class="rundown-item grid grid-cols-1 md:grid-cols-12 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Waktu Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="rundowns[0][waktu_mulai]" value="{{ old('rundowns.0.waktu_mulai', '08:00') }}" required
                               class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Waktu Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="rundowns[0][waktu_selesai]" value="{{ old('rundowns.0.waktu_selesai', '09:00') }}" required
                               class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Sesi / Agenda <span class="text-rose-500">*</span></label>
                        <input type="text" name="rundowns[0][nama_sesi]" value="{{ old('rundowns.0.nama_sesi', 'Registrasi & Pembukaan') }}" required maxlength="150"
                               placeholder="Contoh: Sesi Inti / Registrasi"
                               class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pemateri / PIC</label>
                        <input type="text" name="rundowns[0][pemateri_atau_pic]" value="{{ old('rundowns.0.pemateri_atau_pic') }}" maxlength="150"
                               placeholder="Contoh: MC / Pemateri A"
                               class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
                    </div>
                    <div class="md:col-span-1 flex items-end justify-end">
                        <button type="button" onclick="hapusBaris(this)"
                                class="w-full py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Baris Ini">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('events.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                Batal
            </a>
            <button type="submit" class="px-7 py-2.5 bg-purple-700 hover:bg-purple-800 text-white text-sm font-semibold rounded-xl shadow-md transition">
                Simpan & Terbitkan Event (T1)
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let rowIndex = 1;

    document.getElementById('btn-tambah-sesi').addEventListener('click', function() {
        const wrapper = document.getElementById('rundown-wrapper');
        const newRow = document.createElement('div');
        newRow.className = 'rundown-item grid grid-cols-1 md:grid-cols-12 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200';
        newRow.innerHTML = `
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Waktu Mulai <span class="text-rose-500">*</span></label>
                <input type="time" name="rundowns[${rowIndex}][waktu_mulai]" required
                       class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Waktu Selesai <span class="text-rose-500">*</span></label>
                <input type="time" name="rundowns[${rowIndex}][waktu_selesai]" required
                       class="w-full px-2.5 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
            </div>
            <div class="md:col-span-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Sesi / Agenda <span class="text-rose-500">*</span></label>
                <input type="text" name="rundowns[${rowIndex}][nama_sesi]" required maxlength="150"
                       placeholder="Contoh: Pemaparan Materi / Q&A"
                       class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pemateri / PIC</label>
                <input type="text" name="rundowns[${rowIndex}][pemateri_atau_pic]" maxlength="150"
                       placeholder="Contoh: Pemateri Utama"
                       class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-purple-600">
            </div>
            <div class="md:col-span-1 flex items-end justify-end">
                <button type="button" onclick="hapusBaris(this)"
                        class="w-full py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Baris Ini">
                    Hapus
                </button>
            </div>
        `;
        wrapper.appendChild(newRow);
        rowIndex++;
    });

    function hapusBaris(button) {
        const items = document.querySelectorAll('.rundown-item');
        if (items.length <= 1) {
            alert('Minimal harus ada 1 baris sesi rundown pada pengajuan event!');
            return;
        }
        button.closest('.rundown-item').remove();
    }
</script>
@endpush
@endsection
