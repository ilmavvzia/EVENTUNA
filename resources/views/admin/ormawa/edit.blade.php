@extends('layouts.app')

@section('title', 'Edit Organisasi - ' . $ormawa->name . ' - EVENTUNA')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col">

    <!-- Top Navigation Bar Admin -->
    <header class="bg-[#1e1b4b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.index') }}" class="text-xl font-bold tracking-wide text-purple-300 hover:text-purple-200 transition">
                EVENTUNA
            </a>
            <span class="text-xs bg-purple-700/60 px-2.5 py-1 rounded-full text-purple-100 font-medium">Panel Super Admin</span>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('admin.master.index') }}" class="text-slate-300 hover:text-white transition">Data Master</a>
            <a href="{{ route('admin.ormawa.index') }}" class="text-white font-semibold underline underline-offset-8 decoration-purple-400">Manajemen Ormawa</a>
            <a href="{{ url('/dashboard') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Breadcrumb & Title -->
        <div>
            <a href="{{ route('admin.ormawa.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Direktori Ormawa
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-2">Edit Data Organisasi Mahasiswa</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui data profil, status verifikasi akun, atau berkas legalitas organisasi.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <form action="{{ route('admin.ormawa.update', $ormawa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section 1: Informasi Akun -->
                <div>
                    <h2 class="text-base font-bold text-slate-800 mb-1 border-b border-slate-100 pb-2">1. Informasi Akun & Akses Login</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        
                        <!-- Nama Organisasi -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Nama Organisasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $ormawa->name) }}"
                                   required
                                   class="w-full px-4 py-2.5 border @error('name') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('name')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Organisasi -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Email Resmi Organisasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $ormawa->email) }}"
                                   required
                                   class="w-full px-4 py-2.5 border @error('email') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('email')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password (Opsional) -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Password Baru <span class="text-xs font-normal text-slate-500">(Kosongkan jika tidak diubah)</span>
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Minimal 8 karakter..."
                                   class="w-full px-4 py-2.5 border @error('password') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('password')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Section 2: Klasifikasi & Status Akun -->
                <div>
                    <h2 class="text-base font-bold text-slate-800 mb-1 border-b border-slate-100 pb-2">2. Klasifikasi & Status Akun</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                        
                        <!-- Fakultas -->
                        <div>
                            <label for="fakultas_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Fakultas / Unit Naungan
                            </label>
                            <select id="fakultas_id" name="fakultas_id" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="">Tingkat Universitas (Pusat)</option>
                                @foreach($fakultas as $fak)
                                    <option value="{{ $fak->id }}" {{ old('fakultas_id', $ormawa->fakultas_id) == $fak->id ? 'selected' : '' }}>
                                        {{ $fak->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fakultas_id')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Ormawa -->
                        <div>
                            <label for="jenis_ormawa_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Jenis Organisasi
                            </label>
                            <select id="jenis_ormawa_id" name="jenis_ormawa_id" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="">Pilih Jenis Ormawa</option>
                                @foreach($jenisOrmawas as $jo)
                                    <option value="{{ $jo->id }}" {{ old('jenis_ormawa_id', $ormawa->jenis_ormawa_id) == $jo->id ? 'selected' : '' }}>
                                        {{ $jo->nama_jenis }} - {{ $jo->deskripsi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_ormawa_id')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Akun -->
                        <div>
                            <label for="status_akun" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Status Verifikasi Akun <span class="text-rose-500">*</span>
                            </label>
                            <select id="status_akun" name="status_akun" required class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white font-medium">
                                <option value="verified" {{ old('status_akun', $ormawa->status_akun) === 'verified' ? 'selected' : '' }}>Verified (Aktif)</option>
                                <option value="pending" {{ old('status_akun', $ormawa->status_akun) === 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                                <option value="rejected" {{ old('status_akun', $ormawa->status_akun) === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak / Nonaktif)</option>
                            </select>
                            @error('status_akun')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Section 3: Profil & Berkas Pendukung -->
                <div>
                    <h2 class="text-base font-bold text-slate-800 mb-1 border-b border-slate-100 pb-2">3. Profil & Berkas Pendukung</h2>
                    <div class="space-y-4 mt-4">
                        
                        <!-- Deskripsi Singkat -->
                        <div>
                            <label for="deskripsi_singkat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Deskripsi Singkat Profil Organisasi
                            </label>
                            <textarea id="deskripsi_singkat"
                                      name="deskripsi_singkat"
                                      rows="3"
                                      placeholder="Tuliskan latar belakang, visi, atau lingkup program kerja ormawa ini..."
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi_singkat', $ormawa->deskripsi_singkat) }}</textarea>
                            @error('deskripsi_singkat')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Logo Organisasi -->
                            <div>
                                <label for="logo" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Logo Organisasi <span class="text-xs font-normal text-slate-500">(Upload baru jika ingin mengganti)</span>
                                </label>
                                @if($ormawa->logo_path)
                                    <div class="flex items-center gap-3 mb-2 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                        <img src="{{ asset('storage/' . $ormawa->logo_path) }}" alt="Logo Saat Ini" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                        <span class="text-xs text-slate-500">Logo saat ini telah terpasang</span>
                                    </div>
                                @endif
                                <input type="file"
                                       id="logo"
                                       name="logo"
                                       accept="image/png,image/jpeg,image/jpg"
                                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-slate-300 rounded-xl p-1.5">
                                @error('logo')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SK Kepengurusan -->
                            <div>
                                <label for="sk_kepengurusan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Surat Keputusan (SK) <span class="text-xs font-normal text-slate-500">(Upload baru jika ingin mengganti)</span>
                                </label>
                                @if($ormawa->sk_kepengurusan_path)
                                    <div class="flex items-center justify-between gap-2 mb-2 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                        <span class="text-xs text-slate-600 font-medium truncate">Berkas SK tersedia</span>
                                        <a href="{{ asset('storage/' . $ormawa->sk_kepengurusan_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline font-semibold shrink-0">Lihat SK</a>
                                    </div>
                                @endif
                                <input type="file"
                                       id="sk_kepengurusan"
                                       name="sk_kepengurusan"
                                       accept=".pdf,image/png,image/jpeg,image/jpg"
                                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer border border-slate-300 rounded-xl p-1.5">
                                @error('sk_kepengurusan')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.ormawa.index') }}"
                       class="px-5 py-2.5 border border-slate-300 text-slate-700 hover:bg-slate-100 font-semibold text-sm rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-sm transition">
                        Perbarui Data Ormawa
                    </button>
                </div>

            </form>
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; 2026 EVENTUNA &mdash; Portal Informasi Kegiatan & Manajemen SKP Mahasiswa Universitas Airlangga.
    </footer>

</div>
@endsection
